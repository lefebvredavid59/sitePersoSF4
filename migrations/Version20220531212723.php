<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531212723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_FCBD6ACEDDCA448 ON collection_edition');
        $this->addSql('ALTER TABLE collection_edition DROP subcategory, CHANGE picture picture VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCBD6ACE16DB4F89 ON collection_edition (picture)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_FCBD6ACE16DB4F89 ON collection_edition');
        $this->addSql('ALTER TABLE collection_edition ADD subcategory VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE picture picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCBD6ACEDDCA448 ON collection_edition (subcategory)');
    }
}
