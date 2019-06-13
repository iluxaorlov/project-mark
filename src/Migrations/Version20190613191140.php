<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190613191140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE follow (user INT NOT NULL, following INT NOT NULL, INDEX IDX_683444708D93D649 (user), INDEX IDX_6834447071BF8DE3 (following), PRIMARY KEY(user, following)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE follow ADD CONSTRAINT FK_683444708D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE follow ADD CONSTRAINT FK_6834447071BF8DE3 FOREIGN KEY (following) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE follow');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
