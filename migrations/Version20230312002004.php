<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230312002004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rick_and_morty_status (rick_and_morty_id INT NOT NULL, status_id INT NOT NULL, INDEX IDX_16B77E5142C7229 (rick_and_morty_id), INDEX IDX_16B77E56BF700BD (status_id), PRIMARY KEY(rick_and_morty_id, status_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rick_and_morty_status ADD CONSTRAINT FK_16B77E5142C7229 FOREIGN KEY (rick_and_morty_id) REFERENCES rick_and_morty (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rick_and_morty_status ADD CONSTRAINT FK_16B77E56BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rick_and_morty_status DROP FOREIGN KEY FK_16B77E5142C7229');
        $this->addSql('ALTER TABLE rick_and_morty_status DROP FOREIGN KEY FK_16B77E56BF700BD');
        $this->addSql('DROP TABLE rick_and_morty_status');
        $this->addSql('DROP TABLE status');
    }
}
