<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531193217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collection_category CHANGE slug slug VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F7CCD7F1989D9B62 ON collection_category (slug)');
        $this->addSql('ALTER TABLE collection_edition DROP FOREIGN KEY FK_FCBD6ACE5DC6FE57');
        $this->addSql('DROP INDEX IDX_FCBD6ACE5DC6FE57 ON collection_edition');
        $this->addSql('ALTER TABLE collection_edition ADD subcategory VARCHAR(128) NOT NULL, DROP subcategory_id, DROP slug');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCBD6ACEDDCA448 ON collection_edition (subcategory)');
        $this->addSql('ALTER TABLE collection_subcategory CHANGE slug slug VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_917638C9989D9B62 ON collection_subcategory (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_F7CCD7F1989D9B62 ON collection_category');
        $this->addSql('ALTER TABLE collection_category CHANGE slug slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_FCBD6ACEDDCA448 ON collection_edition');
        $this->addSql('ALTER TABLE collection_edition ADD subcategory_id INT NOT NULL, ADD slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP subcategory');
        $this->addSql('ALTER TABLE collection_edition ADD CONSTRAINT FK_FCBD6ACE5DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES collection_subcategory (id)');
        $this->addSql('CREATE INDEX IDX_FCBD6ACE5DC6FE57 ON collection_edition (subcategory_id)');
        $this->addSql('DROP INDEX UNIQ_917638C9989D9B62 ON collection_subcategory');
        $this->addSql('ALTER TABLE collection_subcategory CHANGE slug slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
