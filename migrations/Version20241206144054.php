<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241206144054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_C53D045F54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA770FBD26D');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA712469DE2');
        $this->addSql('DROP INDEX IDX_3BAE0AA770FBD26D ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA712469DE2 ON event');
        $this->addSql('ALTER TABLE event ADD categories_id INT DEFAULT NULL, ADD animators_id INT DEFAULT NULL, DROP category_id, DROP animator_id');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A21214B7 FOREIGN KEY (categories_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7D4025B12 FOREIGN KEY (animators_id) REFERENCES animator (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7A21214B7 ON event (categories_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7D4025B12 ON event (animators_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F54177093');
        $this->addSql('DROP TABLE image');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A21214B7');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7D4025B12');
        $this->addSql('DROP INDEX IDX_3BAE0AA7A21214B7 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA7D4025B12 ON event');
        $this->addSql('ALTER TABLE event ADD category_id INT DEFAULT NULL, ADD animator_id INT DEFAULT NULL, DROP categories_id, DROP animators_id');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA770FBD26D FOREIGN KEY (animator_id) REFERENCES animator (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA770FBD26D ON event (animator_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA712469DE2 ON event (category_id)');
    }
}
