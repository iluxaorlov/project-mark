<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190615082543 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE post (id VARCHAR(255) NOT NULL, user VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5A8A6C8D8D93D649 (user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE = InnoDB');
        $this->addSql('CREATE TABLE likes (post VARCHAR(255) NOT NULL, user VARCHAR(255) NOT NULL, INDEX IDX_49CA4E7D5A8A6C8D (post), INDEX IDX_49CA4E7D8D93D649 (user), PRIMARY KEY(post, user)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, full_name VARCHAR(255) DEFAULT NULL, about LONGTEXT DEFAULT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE = InnoDB');
        $this->addSql('CREATE TABLE follow (user VARCHAR(255) NOT NULL, following VARCHAR(255) NOT NULL, INDEX IDX_683444708D93D649 (user), INDEX IDX_6834447071BF8DE3 (following), PRIMARY KEY(user, following)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D8D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D5A8A6C8D FOREIGN KEY (post) REFERENCES post (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D8D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE follow ADD CONSTRAINT FK_683444708D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE follow ADD CONSTRAINT FK_6834447071BF8DE3 FOREIGN KEY (following) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D5A8A6C8D');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D8D93D649');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D8D93D649');
        $this->addSql('ALTER TABLE follow DROP FOREIGN KEY FK_683444708D93D649');
        $this->addSql('ALTER TABLE follow DROP FOREIGN KEY FK_6834447071BF8DE3');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE follow');
    }
}
