<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261005173427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return "Agrega la tercera referencia (ref3nombre, ref3mail, ref3recom_name). Los registros existentes quedan con ref3nombre/ref3mail en blanco (DEFAULT '') ya que esos campos no existían al momento de su envío.";
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE registro ADD ref3nombre VARCHAR(255) NOT NULL DEFAULT '', ADD ref3mail VARCHAR(255) NOT NULL DEFAULT '', ADD ref3recom_name VARCHAR(50) DEFAULT NULL");
        $this->addSql('ALTER TABLE registro ALTER ref3nombre DROP DEFAULT, ALTER ref3mail DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registro DROP ref3nombre, DROP ref3mail, DROP ref3recom_name');
    }
}
