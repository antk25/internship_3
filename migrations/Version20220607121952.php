<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220607121952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tickets');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tickets (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', film_session_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', client_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, client_phone BIGINT NOT NULL, INDEX IDX_54469DF4DEDB4197 (film_session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4DEDB4197 FOREIGN KEY (film_session_id) REFERENCES film_sessions (id) ON DELETE CASCADE');
    }
}
