<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261117131730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, date_emprunt DATETIME NOT NULL, date_retour_prevu DATETIME NOT NULL, date_retour_reel DATETIME NOT NULL, utilisateur_id INT DEFAULT NULL, INDEX IDX_364071D7FB88E14F (utilisateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE exemplaire (id INT AUTO_INCREMENT NOT NULL, disponibilite TINYINT NOT NULL, code_inventaire VARCHAR(50) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE exemplaire_oeuvre (exemplaire_id INT NOT NULL, oeuvre_id INT NOT NULL, INDEX IDX_94B40AB35843AA21 (exemplaire_id), INDEX IDX_94B40AB388194DE8 (oeuvre_id), PRIMARY KEY (exemplaire_id, oeuvre_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE oeuvre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(100) NOT NULL, date_sortie DATE NOT NULL, type_oeuvre_id INT DEFAULT NULL, INDEX IDX_35FE2EFE3CDF0CF8 (type_oeuvre_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE type_oeuvre (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, mdp VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id))');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE exemplaire_oeuvre ADD CONSTRAINT FK_94B40AB35843AA21 FOREIGN KEY (exemplaire_id) REFERENCES exemplaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exemplaire_oeuvre ADD CONSTRAINT FK_94B40AB388194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE3CDF0CF8 FOREIGN KEY (type_oeuvre_id) REFERENCES type_oeuvre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7FB88E14F');
        $this->addSql('ALTER TABLE exemplaire_oeuvre DROP FOREIGN KEY FK_94B40AB35843AA21');
        $this->addSql('ALTER TABLE exemplaire_oeuvre DROP FOREIGN KEY FK_94B40AB388194DE8');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE3CDF0CF8');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('DROP TABLE exemplaire');
        $this->addSql('DROP TABLE exemplaire_oeuvre');
        $this->addSql('DROP TABLE oeuvre');
        $this->addSql('DROP TABLE type_oeuvre');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
