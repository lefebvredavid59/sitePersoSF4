<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531164837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collection_edition (id INT AUTO_INCREMENT NOT NULL, subcategory_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_FCBD6ACE5DC6FE57 (subcategory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collection_edition ADD CONSTRAINT FK_FCBD6ACE5DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES collection_subcategory (id)');
        $this->addSql('ALTER TABLE collection_category ADD picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE collection_subcategory ADD picture VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE collection_edition');
        $this->addSql('ALTER TABLE collection_category DROP picture');
        $this->addSql('ALTER TABLE collection_subcategory DROP picture');
    }
}
