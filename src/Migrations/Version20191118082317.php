<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191118082317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, nb_billet INT NOT NULL, prix_total INT DEFAULT NULL, numero_commande CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(255) NOT NULL, formule TINYINT(1) NOT NULL, date_commande DATETIME NOT NULL, UNIQUE INDEX UNIQ_6EEAA67DCFFD611D (numero_commande), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billet (id INT AUTO_INCREMENT NOT NULL, billet_commande_id INT NOT NULL, nom VARCHAR(15) NOT NULL, prenom VARCHAR(15) NOT NULL, pays VARCHAR(255) NOT NULL, reduction TINYINT(1) NOT NULL, date_naissance DATETIME NOT NULL, prix INT NOT NULL, INDEX IDX_1F034AF6DB4EA096 (billet_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF6DB4EA096 FOREIGN KEY (billet_commande_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF6DB4EA096');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE billet');
    }
}
