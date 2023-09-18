<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908103857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bot_user_token (id VARCHAR(26) NOT NULL, created_at INT NOT NULL, refresh_at INT NOT NULL, token VARCHAR(64) NOT NULL, user_id INT NOT NULL, ip VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7FE9C545F37A13B ON bot_user_token (token)');
        $this->addSql('CREATE TABLE "user" (id VARCHAR(26) NOT NULL, created_at INT NOT NULL, refresh_at INT NOT NULL, token VARCHAR(64) NOT NULL, user_id INT NOT NULL, ip VARCHAR(255) NOT NULL, user_agent VARCHAR(255) NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495F37A13B ON "user" (token)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE bot_user_token');
        $this->addSql('DROP TABLE "user"');
    }
}
