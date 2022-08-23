<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804132125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boisson_taille_boisson (boisson_id INT NOT NULL, taille_boisson_id INT NOT NULL, INDEX IDX_3AAEDEC8734B8089 (boisson_id), INDEX IDX_3AAEDEC88421F13F (taille_boisson_id), PRIMARY KEY(boisson_id, taille_boisson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boisson_taille_boisson ADD CONSTRAINT FK_3AAEDEC8734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boisson_taille_boisson ADD CONSTRAINT FK_3AAEDEC88421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boisson DROP FOREIGN KEY FK_8B97C84D8421F13F');
        $this->addSql('DROP INDEX IDX_8B97C84D8421F13F ON boisson');
        $this->addSql('ALTER TABLE boisson DROP taille_boisson_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE boisson_taille_boisson');
        $this->addSql('ALTER TABLE boisson ADD taille_boisson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boisson ADD CONSTRAINT FK_8B97C84D8421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id)');
        $this->addSql('CREATE INDEX IDX_8B97C84D8421F13F ON boisson (taille_boisson_id)');
    }
}
