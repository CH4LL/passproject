<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920080322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(20) NOT NULL, CHANGE password password VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE user_conversation CHANGE sender_username sender_username VARCHAR(20) NOT NULL, CHANGE receiver_username receiver_username VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE username username TEXT NOT NULL COLLATE utf8mb4_unicode_520_ci, CHANGE password password TEXT NOT NULL COLLATE utf8mb4_unicode_520_ci');
        $this->addSql('ALTER TABLE user_conversation CHANGE sender_username sender_username TEXT NOT NULL COLLATE latin1_swedish_ci, CHANGE receiver_username receiver_username TEXT NOT NULL COLLATE latin1_swedish_ci');
    }
}
