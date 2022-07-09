<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220708215033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX ville_nom_reel ON ville');
        $this->addSql('DROP INDEX ville_longitude_latitude_deg ON ville');
        $this->addSql('ALTER TABLE ville CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE departement_id departement_id INT DEFAULT NULL, CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE ville_long ville_long DOUBLE PRECISION NOT NULL, CHANGE ville_lat ville_lat DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE ville RENAME INDEX ville_departement TO IDX_43C3D9C3CCF9E01E');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3CCF9E01E');
        $this->addSql('ALTER TABLE ville CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE departement_id departement_id VARCHAR(3) DEFAULT NULL, CHANGE nom nom VARCHAR(45) DEFAULT NULL, CHANGE ville_long ville_long DOUBLE PRECISION DEFAULT NULL, CHANGE ville_lat ville_lat DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('CREATE INDEX ville_nom_reel ON ville (nom)');
        $this->addSql('CREATE INDEX ville_longitude_latitude_deg ON ville (ville_long, ville_lat)');
        $this->addSql('ALTER TABLE ville RENAME INDEX idx_43c3d9c3ccf9e01e TO ville_departement');
    }
}
