<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261002000918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE registro (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, materno VARCHAR(100) DEFAULT NULL, paterno VARCHAR(100) NOT NULL, direccion VARCHAR(500) NOT NULL, mail VARCHAR(255) NOT NULL, solicitud_name VARCHAR(50) DEFAULT NULL, cv_name VARCHAR(50) DEFAULT NULL, comprobante_name VARCHAR(50) DEFAULT NULL, proyecto_name VARCHAR(50) DEFAULT NULL, articulos_name VARCHAR(50) DEFAULT NULL, ref1nombre VARCHAR(255) NOT NULL, ref1mail VARCHAR(255) NOT NULL, ref1recom_name VARCHAR(50) DEFAULT NULL, ref2nombre VARCHAR(255) NOT NULL, ref2mail VARCHAR(255) NOT NULL, ref2recom_name VARCHAR(50) DEFAULT NULL, activo TINYINT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_397CA85B5126AC48 (mail), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE registro');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
