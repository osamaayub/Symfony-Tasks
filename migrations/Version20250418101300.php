<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250418101300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user_details (id SERIAL NOT NULL, user_id INT NOT NULL, address VARCHAR(255) NOT NULL, phone_number VARCHAR(20) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(200) NOT NULL, password VARCHAR(50) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_2A2B1580A76ED395 ON user_details (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_details ADD CONSTRAINT FK_2A2B1580A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" ALTER username TYPE VARCHAR(100)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_details DROP CONSTRAINT FK_2A2B1580A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_details
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" ALTER username TYPE VARCHAR(255)
        SQL);
    }
}
