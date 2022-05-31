<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531224836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collection_edition ADD family_id INT NOT NULL');
        $this->addSql('ALTER TABLE collection_edition ADD CONSTRAINT FK_FCBD6ACEC35E566A FOREIGN KEY (family_id) REFERENCES collection_family (id)');
        $this->addSql('CREATE INDEX IDX_FCBD6ACEC35E566A ON collection_edition (family_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collection_edition DROP FOREIGN KEY FK_FCBD6ACEC35E566A');
        $this->addSql('DROP INDEX IDX_FCBD6ACEC35E566A ON collection_edition');
        $this->addSql('ALTER TABLE collection_edition DROP family_id');
    }
}
