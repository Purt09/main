<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231016003243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE "user"');
        $this->addSql('ALTER TABLE bot_user_token ADD bot_id INT NOT NULL');
        $this->addSql('ALTER TABLE bot_user_token ADD user_agent VARCHAR(1000) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE "user" (id VARCHAR(26) NOT NULL, created_at INT NOT NULL, refresh_at INT DEFAULT NULL, token VARCHAR(64) NOT NULL, user_id INT NOT NULL, ip VARCHAR(255) NOT NULL, user_agent VARCHAR(255) NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d6495f37a13b ON "user" (token)');
        $this->addSql('ALTER TABLE bot_user_token DROP bot_id');
        $this->addSql('ALTER TABLE bot_user_token DROP user_agent');
    }
}
