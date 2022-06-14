<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614034359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE film_sessions (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', date_time_start DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', tickets_count INT NOT NULL, film_title VARCHAR(255) NOT NULL, film_duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tickets (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', film_session_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', client_name VARCHAR(255) NOT NULL, client_phone BIGINT NOT NULL, INDEX IDX_54469DF4DEDB4197 (film_session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4DEDB4197 FOREIGN KEY (film_session_id) REFERENCES film_sessions (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4DEDB4197');
        $this->addSql('DROP TABLE film_sessions');
        $this->addSql('DROP TABLE tickets');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
