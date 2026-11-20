<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;



/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261120144411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auteur_oeuvre (auteur_id INT NOT NULL, oeuvre_id INT NOT NULL, INDEX IDX_1C2D5B8C60BB6FE6 (auteur_id), INDEX IDX_1C2D5B8C88194DE8 (oeuvre_id), PRIMARY KEY (auteur_id, oeuvre_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE categorie_oeuvre (categorie_id INT NOT NULL, oeuvre_id INT NOT NULL, INDEX IDX_B3D884C7BCF5E72D (categorie_id), INDEX IDX_B3D884C788194DE8 (oeuvre_id), PRIMARY KEY (categorie_id, oeuvre_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE oeuvre_categorie (oeuvre_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_50ED1EBF88194DE8 (oeuvre_id), INDEX IDX_50ED1EBFBCF5E72D (categorie_id), PRIMARY KEY (oeuvre_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE oeuvre_auteur (oeuvre_id INT NOT NULL, auteur_id INT NOT NULL, INDEX IDX_C57F95AE88194DE8 (oeuvre_id), INDEX IDX_C57F95AE60BB6FE6 (auteur_id), PRIMARY KEY (oeuvre_id, auteur_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE auteur_oeuvre ADD CONSTRAINT FK_1C2D5B8C60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auteur_oeuvre ADD CONSTRAINT FK_1C2D5B8C88194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_oeuvre ADD CONSTRAINT FK_B3D884C7BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_oeuvre ADD CONSTRAINT FK_B3D884C788194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre_categorie ADD CONSTRAINT FK_50ED1EBF88194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre_categorie ADD CONSTRAINT FK_50ED1EBFBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre_auteur ADD CONSTRAINT FK_C57F95AE88194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre_auteur ADD CONSTRAINT FK_C57F95AE60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt ADD date_retour_reelle DATETIME DEFAULT NULL, ADD exemplaire_id INT DEFAULT NULL, DROP date_retour_reel');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D75843AA21 FOREIGN KEY (exemplaire_id) REFERENCES exemplaire (id)');
        $this->addSql('CREATE INDEX IDX_364071D75843AA21 ON emprunt (exemplaire_id)');
        $this->addSql('ALTER TABLE exemplaire ADD oeuvre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C9288194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id)');
        $this->addSql('CREATE INDEX IDX_5EF83C9288194DE8 ON exemplaire (oeuvre_id)');
        // Supprimer temporairement la clé étrangère
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE3CDF0CF8');

        // Modifier les colonnes
        $this->addSql('ALTER TABLE oeuvre CHANGE date_sortie date_sortie DATETIME NOT NULL, CHANGE type_oeuvre_id type_oeuvre_id INT NOT NULL');

        // Recréer la clé étrangère
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE3CDF0CF8 FOREIGN KEY (type_oeuvre_id) REFERENCES type_oeuvre (id)');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE prenom prenom VARCHAR(100) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auteur_oeuvre DROP FOREIGN KEY FK_1C2D5B8C60BB6FE6');
        $this->addSql('ALTER TABLE auteur_oeuvre DROP FOREIGN KEY FK_1C2D5B8C88194DE8');
        $this->addSql('ALTER TABLE categorie_oeuvre DROP FOREIGN KEY FK_B3D884C7BCF5E72D');
        $this->addSql('ALTER TABLE categorie_oeuvre DROP FOREIGN KEY FK_B3D884C788194DE8');
        $this->addSql('ALTER TABLE oeuvre_categorie DROP FOREIGN KEY FK_50ED1EBF88194DE8');
        $this->addSql('ALTER TABLE oeuvre_categorie DROP FOREIGN KEY FK_50ED1EBFBCF5E72D');
        $this->addSql('ALTER TABLE oeuvre_auteur DROP FOREIGN KEY FK_C57F95AE88194DE8');
        $this->addSql('ALTER TABLE oeuvre_auteur DROP FOREIGN KEY FK_C57F95AE60BB6FE6');
        $this->addSql('DROP TABLE auteur_oeuvre');
        $this->addSql('DROP TABLE categorie_oeuvre');
        $this->addSql('DROP TABLE oeuvre_categorie');
        $this->addSql('DROP TABLE oeuvre_auteur');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D75843AA21');
        $this->addSql('DROP INDEX IDX_364071D75843AA21 ON emprunt');
        $this->addSql('ALTER TABLE emprunt ADD date_retour_reel DATETIME NOT NULL, DROP date_retour_reelle, DROP exemplaire_id');
        $this->addSql('ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C9288194DE8');
        $this->addSql('DROP INDEX IDX_5EF83C9288194DE8 ON exemplaire');
        $this->addSql('ALTER TABLE exemplaire DROP oeuvre_id');
        $this->addSql('ALTER TABLE oeuvre CHANGE date_sortie date_sortie DATE NOT NULL, CHANGE type_oeuvre_id type_oeuvre_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE prenom prenom VARCHAR(50) NOT NULL');
    }
}
