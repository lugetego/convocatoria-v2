<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261013004305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registro CHANGE solicitud_name solicitud_name VARCHAR(255) DEFAULT NULL, CHANGE cv_name cv_name VARCHAR(255) DEFAULT NULL, CHANGE comprobante_name comprobante_name VARCHAR(255) DEFAULT NULL, CHANGE proyecto_name proyecto_name VARCHAR(255) DEFAULT NULL, CHANGE ref1recom_name ref1recom_name VARCHAR(255) DEFAULT NULL, CHANGE ref2recom_name ref2recom_name VARCHAR(255) DEFAULT NULL, CHANGE ref3recom_name ref3recom_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registro CHANGE solicitud_name solicitud_name VARCHAR(50) DEFAULT NULL, CHANGE cv_name cv_name VARCHAR(50) DEFAULT NULL, CHANGE comprobante_name comprobante_name VARCHAR(50) DEFAULT NULL, CHANGE proyecto_name proyecto_name VARCHAR(50) DEFAULT NULL, CHANGE ref1recom_name ref1recom_name VARCHAR(50) DEFAULT NULL, CHANGE ref2recom_name ref2recom_name VARCHAR(50) DEFAULT NULL, CHANGE ref3recom_name ref3recom_name VARCHAR(50) DEFAULT NULL');
    }
}
