<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Crea una cuenta admin nueva, o actualiza su contraseña/roles si el usuario ya existe. Las cuentas viven solo en la base de datos, nunca en archivos del repo.',
)]
class UserCreateCommand extends Command
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'Nombre de usuario')
            ->addArgument('roles', InputArgument::REQUIRED, 'Roles separados por coma, ej: ROLE_ADMIN o ROLE_CONSULTA')
            ->addOption('password', null, InputOption::VALUE_REQUIRED, 'Contraseña en texto plano (evita el prompt oculto; solo para scripts, queda en el historial de la shell).')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = (string) $input->getArgument('username');
        $roles = array_values(array_filter(array_map('trim', explode(',', (string) $input->getArgument('roles')))));

        $plainPassword = $input->getOption('password');
        if (!$plainPassword) {
            $question = new Question('Contraseña: ');
            $question->setHidden(true);
            $question->setHiddenFallback(false);
            $plainPassword = $io->askQuestion($question);
        }

        if (!$plainPassword) {
            $io->error('La contraseña no puede estar vacía.');

            return Command::FAILURE;
        }

        $user = $this->userRepository->findOneBy(['username' => $username]) ?? new User();
        $isNew = null === $user->getId();

        $user->setUsername($username);
        $user->setRoles($roles);
        $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success(\sprintf(
            'Usuario "%s" %s con roles [%s].',
            $username,
            $isNew ? 'creado' : 'actualizado',
            implode(', ', $roles)
        ));

        return Command::SUCCESS;
    }
}
