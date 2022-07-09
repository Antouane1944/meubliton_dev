<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220709094408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5A73F0036 FOREIGN KEY (ville_id) REFERENCES villes (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5A73F0036 ON annonce (ville_id)');
        $this->addSql('ALTER TABLE user CHANGE ville_id ville_id VARCHAR(10) NOT NULL');
        $this->addSql('DROP INDEX ville_nom_reel ON villes');
        $this->addSql('DROP INDEX ville_departement ON villes');
        $this->addSql('DROP INDEX ville_longitude_latitude_deg ON villes');
        $this->addSql('ALTER TABLE villes CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE departement_id departement_id VARCHAR(10) NOT NULL, CHANGE nom nom VARCHAR(150) NOT NULL, CHANGE ville_long ville_long DOUBLE PRECISION NOT NULL, CHANGE ville_lat ville_lat DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5A73F0036');
        $this->addSql('DROP INDEX IDX_F65593E5A73F0036 ON annonce');
        $this->addSql('ALTER TABLE annonce DROP ville_id');
        $this->addSql('ALTER TABLE `user` CHANGE ville_id ville_id INT NOT NULL');
        $this->addSql('ALTER TABLE villes CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE nom nom VARCHAR(45) DEFAULT NULL, CHANGE departement_id departement_id VARCHAR(3) DEFAULT NULL, CHANGE ville_long ville_long DOUBLE PRECISION DEFAULT NULL, CHANGE ville_lat ville_lat DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('CREATE INDEX ville_nom_reel ON villes (nom)');
        $this->addSql('CREATE INDEX ville_departement ON villes (departement_id)');
        $this->addSql('CREATE INDEX ville_longitude_latitude_deg ON villes (ville_long, ville_lat)');
    }
}
