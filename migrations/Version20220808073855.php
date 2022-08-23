<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220808073855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE commande ADD ligne_dcommandes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D3A7DF3A2 FOREIGN KEY (ligne_dcommandes_id) REFERENCES ligne_commande (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D3A7DF3A2 ON commande (ligne_dcommandes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D3A7DF3A2');
        $this->addSql('DROP INDEX IDX_6EEAA67D3A7DF3A2 ON commande');
        // $this->addSql('ALTER TABLE commande DROP ligne_dcommandes_id');
    }
}
