<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220603123422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collection_edition ADD subcategory_id INT NOT NULL');
        $this->addSql('ALTER TABLE collection_edition ADD CONSTRAINT FK_FCBD6ACE5DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES collection_subcategory (id)');
        $this->addSql('CREATE INDEX IDX_FCBD6ACE5DC6FE57 ON collection_edition (subcategory_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collection_edition DROP FOREIGN KEY FK_FCBD6ACE5DC6FE57');
        $this->addSql('DROP INDEX IDX_FCBD6ACE5DC6FE57 ON collection_edition');
        $this->addSql('ALTER TABLE collection_edition DROP subcategory_id');
    }
}
