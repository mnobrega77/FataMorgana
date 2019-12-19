<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191219095820 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE englobe DROP FOREIGN KEY englobe_ibfk_2');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_2');
        $this->addSql('ALTER TABLE bonlivraison DROP FOREIGN KEY bonlivraison_ibfk_1');
        $this->addSql('ALTER TABLE contient DROP FOREIGN KEY contient_ibfk_2');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY client_ibfk_1');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY commande_ibfk_1');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE bonlivraison');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commercial');
        $this->addSql('DROP TABLE contient');
        $this->addSql('DROP TABLE englobe');
        $this->addSql('DROP TABLE facture');
        $this->addSql('ALTER TABLE auteur CHANGE aut_nom aut_nom VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE cat_nom cat_nom VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE editeur CHANGE edit_nom edit_nom VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE fournisseur CHANGE four_nom four_nom VARCHAR(50) NOT NULL, CHANGE four_ad four_ad VARCHAR(50) NOT NULL, CHANGE four_contact four_contact VARCHAR(50) NOT NULL, CHANGE four_cp four_cp VARCHAR(15) NOT NULL, CHANGE four_ville four_ville VARCHAR(30) NOT NULL, CHANGE four_tel four_tel VARCHAR(20) NOT NULL, CHANGE four_pays four_pays VARCHAR(30) NOT NULL, CHANGE four_email four_email VARCHAR(30) NOT NULL, CHANGE four_type four_type VARCHAR(6) NOT NULL');
        $this->addSql('ALTER TABLE livre CHANGE lvr_ref lvr_ref VARCHAR(30) NOT NULL, CHANGE lvr_detail lvr_detail VARCHAR(200) NOT NULL, CHANGE lvr_titre lvr_titre VARCHAR(150) NOT NULL, CHANGE lvr_resume lvr_resume LONGTEXT NOT NULL, CHANGE lvr_prachat lvr_prachat DOUBLE PRECISION NOT NULL, CHANGE lvr_photo lvr_photo VARCHAR(200) DEFAULT NULL, CHANGE lvr_stock lvr_stock INT NOT NULL, CHANGE lvr_date_edition lvr_date_edition DATE NOT NULL');
        $this->addSql('ALTER TABLE livre RENAME INDEX scat_id TO IDX_AC634F9917831D28');
        $this->addSql('ALTER TABLE livre RENAME INDEX aut_id TO IDX_AC634F993E05390A');
        $this->addSql('ALTER TABLE livre RENAME INDEX edit_id TO IDX_AC634F993EF8CFA5');
        $this->addSql('ALTER TABLE livre RENAME INDEX four_id TO IDX_AC634F99E5AC00A4');
        $this->addSql('ALTER TABLE souscategorie CHANGE scat_nom scat_nom VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE souscategorie RENAME INDEX cat_id TO IDX_6FF3A701E6ADA943');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bonlivraison (livr_id INT NOT NULL, cmmd_id INT DEFAULT NULL, livr_date DATE DEFAULT \'NULL\', INDEX cmmd_id (cmmd_id), PRIMARY KEY(livr_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE client (cli_id INT AUTO_INCREMENT NOT NULL, comm_ref VARCHAR(6) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, cli_nom VARCHAR(30) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cli_prenom VARCHAR(30) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cli_ad VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cli_cp VARCHAR(10) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cli_ville VARCHAR(20) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cli_tel VARCHAR(20) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cli_email VARCHAR(30) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cli_mdp VARCHAR(15) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cli_type VARCHAR(4) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cli_coeff NUMERIC(2, 1) DEFAULT \'NULL\', INDEX comm_ref (comm_ref), PRIMARY KEY(cli_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande (cmmd_id INT AUTO_INCREMENT NOT NULL, fact_id INT DEFAULT NULL, cli_id INT NOT NULL, cmmd_date DATE DEFAULT \'NULL\', cmmd_adfact VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cmmd_cpfact VARCHAR(10) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cmmd_villefact VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cmmd_adlivr VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cmmd_cplivr VARCHAR(10) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cmmd_villelivr VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, cmmd_obs VARCHAR(150) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, INDEX fact_id (fact_id), INDEX cli_id (cli_id), PRIMARY KEY(cmmd_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commercial (comm_ref VARCHAR(6) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, comm_attr VARCHAR(4) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, comm_nom VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, comm_ad VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, comm_cp VARCHAR(10) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, comm_ville VARCHAR(20) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, comm_email VARCHAR(30) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, comm_mdp VARCHAR(15) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, comm_tel VARCHAR(20) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, PRIMARY KEY(comm_ref)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contient (lvr_id VARCHAR(10) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, cmmd_id INT NOT NULL, cmmd_qte INT DEFAULT NULL, lvr_prunitHT NUMERIC(9, 2) DEFAULT \'NULL\', INDEX cmmd_id (cmmd_id), INDEX IDX_DC302E56E0500FD8 (lvr_id), PRIMARY KEY(lvr_id, cmmd_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE englobe (lvr_id VARCHAR(10) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, livr_id INT NOT NULL, prod_qtelivre INT DEFAULT NULL, INDEX livr_id (livr_id), INDEX IDX_566211FE0500FD8 (lvr_id), PRIMARY KEY(lvr_id, livr_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE facture (fact_id INT AUTO_INCREMENT NOT NULL, fact_date DATE DEFAULT \'NULL\', fact_totalHT NUMERIC(6, 2) DEFAULT \'NULL\', fact_tva NUMERIC(4, 2) DEFAULT \'NULL\', fact_reduc NUMERIC(4, 2) DEFAULT \'NULL\', fact_totalTTC NUMERIC(7, 2) DEFAULT \'NULL\', PRIMARY KEY(fact_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bonlivraison ADD CONSTRAINT bonlivraison_ibfk_1 FOREIGN KEY (cmmd_id) REFERENCES commande (cmmd_id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT client_ibfk_1 FOREIGN KEY (comm_ref) REFERENCES commercial (comm_ref)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_1 FOREIGN KEY (fact_id) REFERENCES facture (fact_id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT commande_ibfk_2 FOREIGN KEY (cli_id) REFERENCES client (cli_id)');
        $this->addSql('ALTER TABLE contient ADD CONSTRAINT contient_ibfk_1 FOREIGN KEY (lvr_id) REFERENCES livre (lvr_id)');
        $this->addSql('ALTER TABLE contient ADD CONSTRAINT contient_ibfk_2 FOREIGN KEY (cmmd_id) REFERENCES commande (cmmd_id)');
        $this->addSql('ALTER TABLE englobe ADD CONSTRAINT englobe_ibfk_1 FOREIGN KEY (lvr_id) REFERENCES livre (lvr_id)');
        $this->addSql('ALTER TABLE englobe ADD CONSTRAINT englobe_ibfk_2 FOREIGN KEY (livr_id) REFERENCES bonlivraison (livr_id)');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE auteur CHANGE aut_nom aut_nom VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE categorie CHANGE cat_nom cat_nom VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE editeur CHANGE edit_nom edit_nom VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE fournisseur CHANGE four_nom four_nom VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE four_ad four_ad VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE four_contact four_contact VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE four_cp four_cp VARCHAR(15) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE four_ville four_ville VARCHAR(30) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE four_tel four_tel VARCHAR(20) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE four_pays four_pays VARCHAR(30) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE four_email four_email VARCHAR(30) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE four_type four_type VARCHAR(6) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE livre CHANGE lvr_ref lvr_ref VARCHAR(30) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE lvr_detail lvr_detail VARCHAR(200) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE lvr_titre lvr_titre VARCHAR(150) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE lvr_resume lvr_resume TEXT CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE lvr_prachat lvr_prachat NUMERIC(6, 2) DEFAULT \'NULL\', CHANGE lvr_photo lvr_photo VARCHAR(200) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`, CHANGE lvr_stock lvr_stock INT DEFAULT NULL, CHANGE lvr_date_edition lvr_date_edition DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE livre RENAME INDEX idx_ac634f99e5ac00a4 TO four_id');
        $this->addSql('ALTER TABLE livre RENAME INDEX idx_ac634f993ef8cfa5 TO edit_id');
        $this->addSql('ALTER TABLE livre RENAME INDEX idx_ac634f9917831d28 TO scat_id');
        $this->addSql('ALTER TABLE livre RENAME INDEX idx_ac634f993e05390a TO aut_id');
        $this->addSql('ALTER TABLE souscategorie CHANGE scat_nom scat_nom VARCHAR(50) CHARACTER SET latin1 DEFAULT \'NULL\' COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE souscategorie RENAME INDEX idx_6ff3a701e6ada943 TO cat_id');
    }
}
