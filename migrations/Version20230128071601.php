<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230128071601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update Github::description for LONGTEXT. Add GitHub::apiUrl.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE git_hub CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE git_hub ADD api_url VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE git_hub CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE git_hub DROP api_url');
    }
}
