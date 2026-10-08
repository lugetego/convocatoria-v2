<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261005174843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Elimina el campo de sobretiros de artículos (ya no se solicita). Los PDFs ya subidos quedan huérfanos en public/uploads/submissions/, no se borran.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE registro DROP articulos_name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registro ADD articulos_name VARCHAR(50) DEFAULT NULL');
    }
}
