<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220808075917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_ligne_commande (commande_id INT NOT NULL, ligne_commande_id INT NOT NULL, INDEX IDX_F42BB89182EA2E54 (commande_id), INDEX IDX_F42BB891E10FEE63 (ligne_commande_id), PRIMARY KEY(commande_id, ligne_commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_ligne_commande ADD CONSTRAINT FK_F42BB89182EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_ligne_commande ADD CONSTRAINT FK_F42BB891E10FEE63 FOREIGN KEY (ligne_commande_id) REFERENCES ligne_commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D3A7DF3A2');
        $this->addSql('DROP INDEX IDX_6EEAA67D3A7DF3A2 ON commande');
        $this->addSql('ALTER TABLE commande DROP ligne_dcommandes_id, CHANGE numero_commande numero_commande VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B82EA2E54');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74BF347EFB');
        $this->addSql('DROP INDEX IDX_3170B74BF347EFB ON ligne_commande');
        $this->addSql('DROP INDEX IDX_3170B74B82EA2E54 ON ligne_commande');
        $this->addSql('ALTER TABLE ligne_commande DROP produit_id, DROP commande_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commande_ligne_commande');
        $this->addSql('ALTER TABLE commande ADD ligne_dcommandes_id INT DEFAULT NULL, CHANGE numero_commande numero_commande INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D3A7DF3A2 FOREIGN KEY (ligne_dcommandes_id) REFERENCES ligne_commande (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D3A7DF3A2 ON commande (ligne_dcommandes_id)');
        $this->addSql('ALTER TABLE ligne_commande ADD produit_id INT DEFAULT NULL, ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74BF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_3170B74BF347EFB ON ligne_commande (produit_id)');
        $this->addSql('CREATE INDEX IDX_3170B74B82EA2E54 ON ligne_commande (commande_id)');
    }
}
