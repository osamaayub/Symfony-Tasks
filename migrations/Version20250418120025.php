<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250418120025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" DROP CONSTRAINT fk_8d93d649ccfa12b8
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX uniq_8d93d649ccfa12b8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" DROP profile_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_details ALTER user_id DROP NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" ADD profile_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649ccfa12b8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_8d93d649ccfa12b8 ON "user" (profile_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_details ALTER user_id SET NOT NULL
        SQL);
    }
}
