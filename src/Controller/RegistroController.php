<?php

namespace App\Controller;

use App\Entity\Registro;
use App\Form\RegistroType;
use App\Repository\RegistroRepository;
use App\Service\RegistrationDeadline;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/registro')]
class RegistroController extends AbstractController
{
    #[Route('/', name: 'registro_index', methods: ['GET'])]
    #[Route('/all', name: 'registro_all', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function list(RegistroRepository $registroRepository): Response
    {
        return $this->render('registro/list.html.twig', [
            'registros' => $registroRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'registro_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        RegistrationDeadline $deadline,
        string $mailerFromAddress,
        string $mailerBccAddress,
    ): Response {
        if ($deadline->isClosed()) {
            return $this->render('registro/new.html.twig', [
                'closed' => true,
                'deadline' => $deadline->getDeadline(),
                'form' => null,
            ]);
        }

        $registro = new Registro();
        $form = $this->createForm(RegistroType::class, $registro);
        $form->remove('ref1recomFile');
        $form->remove('ref2recomFile');
        $form->remove('ref3recomFile');
        $form->remove('activo');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registro->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($registro);
            $entityManager->flush();
            $this->clearUploadedFiles($registro);

            $mailer->send((new TemplatedEmail())
                ->subject('Acuse de recibo/Acknowledgment')
                ->from($mailerFromAddress)
                ->to($registro->getMail())
                ->bcc($mailerBccAddress)
                ->textTemplate('emails/mail.txt.twig')
                ->context(['entity' => $registro]));

            $this->sendRecomInvite($mailer, $registro, 1, $registro->getRef1nombre(), $registro->getRef1mail(), $mailerFromAddress, $mailerBccAddress);
            $this->sendRecomInvite($mailer, $registro, 2, $registro->getRef2nombre(), $registro->getRef2mail(), $mailerFromAddress, $mailerBccAddress);
            $this->sendRecomInvite($mailer, $registro, 3, $registro->getRef3nombre(), $registro->getRef3mail(), $mailerFromAddress, $mailerBccAddress);

            // Redirigir (en vez de renderizar directo) evita el patrón "re-mostrar formulario" que
            // Turbo Drive asume ante una respuesta 200 a un POST, y previene el reenvío al recargar.
            return $this->redirectToRoute('registro_confirm', ['id' => $registro->getId()]);
        }

        return $this->render('registro/new.html.twig', [
            'closed' => false,
            'registro' => $registro,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/confirmado', name: 'registro_confirm', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function confirm(Registro $registro): Response
    {
        return $this->render('registro/confirm.html.twig', [
            'entity' => $registro,
        ]);
    }

    private function sendRecomInvite(
        MailerInterface $mailer,
        Registro $registro,
        int $refNum,
        ?string $referencia,
        ?string $mailref,
        string $mailerFromAddress,
        string $mailerBccAddress,
    ): void {
        $url = $this->generateUrl('registro_recom', [
            'id' => $registro->getId(),
            'ref' => $refNum,
            'mail' => $registro->getMail(),
            'mailref' => $mailref,
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $mailer->send((new TemplatedEmail())
            ->subject('Recomendación/Recommendation')
            ->from($mailerFromAddress)
            ->to($mailref)
            ->bcc($mailerBccAddress)
            ->textTemplate('emails/mail_ref.txt.twig')
            ->context([
                'entity' => $registro,
                'referencia' => $referencia,
                'mailref' => $mailref,
                'refNum' => $refNum,
                'url' => $url,
            ]));
    }

    #[Route('/{id}/{ref}/{mail}/{mailref}/recom', name: 'registro_recom', requirements: ['id' => '\d+', 'ref' => '\d+'], methods: ['GET', 'POST'])]
    public function recom(
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        Registro $registro,
        string $mail,
        int $id,
        int $ref,
        string $mailerFromAddress,
        string $mailerBccAddress,
    ): Response {
        if ($mail !== $registro->getMail() || $id !== $registro->getId()) {
            throw $this->createNotFoundException('Existe algún problema con la información de registro');
        }

        $refRecomName = match ($ref) {
            1 => $registro->getRef1recomName(),
            2 => $registro->getRef2recomName(),
            3 => $registro->getRef3recomName(),
            default => throw $this->createNotFoundException('Referencia inválida'),
        };

        if (null !== $refRecomName) {
            return $this->render('registro/confirm_recom.html.twig', ['entity' => $registro]);
        }

        $editForm = $this->createForm(RegistroType::class, $registro);
        foreach ([
            'nombre', 'paterno', 'materno', 'mail', 'direccion',
            'solicitudFile', 'cvFile', 'comprobanteFile', 'proyectoFile', 'articulosFile',
            'ref1nombre', 'ref2nombre', 'ref3nombre', 'ref1mail', 'ref2mail', 'ref3mail', 'activo',
        ] as $field) {
            $editForm->remove($field);
        }

        foreach ([1, 2, 3] as $otherRef) {
            if ($otherRef !== $ref) {
                $editForm->remove("ref{$otherRef}recomFile");
            }
        }

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $registro->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->persist($registro);
            $entityManager->flush();
            $this->clearUploadedFiles($registro);

            $refnombre = match ($ref) {
                1 => $registro->getRef1nombre(),
                2 => $registro->getRef2nombre(),
                3 => $registro->getRef3nombre(),
            };
            $refmail = match ($ref) {
                1 => $registro->getRef1mail(),
                2 => $registro->getRef2mail(),
                3 => $registro->getRef3mail(),
            };

            $mailer->send((new TemplatedEmail())
                ->subject('Recomendación / Recommendation')
                ->from($mailerFromAddress)
                ->to($refmail)
                ->cc($registro->getMail())
                ->bcc($mailerBccAddress)
                ->textTemplate('emails/mail_carta.txt.twig')
                ->context(['entity' => $registro, 'refnombre' => $refnombre]));

            return $this->redirectToRoute('registro_confirm_carta', ['id' => $registro->getId()]);
        }

        return $this->render('registro/recom.html.twig', [
            'registro' => $registro,
            'edit_form' => $editForm->createView(),
        ]);
    }

    #[Route('/{id}/carta-confirmada', name: 'registro_confirm_carta', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function confirmCarta(Registro $registro): Response
    {
        return $this->render('registro/confirm_carta.html.twig', ['entity' => $registro]);
    }

    #[Route('/{id}', name: 'registro_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show(Registro $registro): Response
    {
        return $this->render('registro/show.html.twig', [
            'registro' => $registro,
        ]);
    }

    /**
     * Symfony\Component\HttpFoundation\File\File rechaza ser serializado; una vez que Vich ya movió
     * el archivo a su destino final (durante el flush), no necesitamos conservar la referencia en
     * memoria y dejarla provoca un 500 en dev cuando el profiler intenta volcar la respuesta.
     */
    private function clearUploadedFiles(Registro $registro): void
    {
        $registro->solicitudFile = null;
        $registro->cvFile = null;
        $registro->comprobanteFile = null;
        $registro->proyectoFile = null;
        $registro->articulosFile = null;
        $registro->ref1recomFile = null;
        $registro->ref2recomFile = null;
        $registro->ref3recomFile = null;
    }
}
