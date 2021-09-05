<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210902221532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trade_comment DROP FOREIGN KEY FK_67F40A9AC2D9760');
        $this->addSql('ALTER TABLE trade_comment DROP FOREIGN KEY FK_67F40A9AF675F31B');
        $this->addSql('ALTER TABLE trade_comment CHANGE author_id author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trade_comment ADD CONSTRAINT FK_67F40A9AC2D9760 FOREIGN KEY (trade_id) REFERENCES trade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trade_comment ADD CONSTRAINT FK_67F40A9AF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trade_comment DROP FOREIGN KEY FK_67F40A9AF675F31B');
        $this->addSql('ALTER TABLE trade_comment DROP FOREIGN KEY FK_67F40A9AC2D9760');
        $this->addSql('ALTER TABLE trade_comment CHANGE author_id author_id INT NOT NULL');
        $this->addSql('ALTER TABLE trade_comment ADD CONSTRAINT FK_67F40A9AF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trade_comment ADD CONSTRAINT FK_67F40A9AC2D9760 FOREIGN KEY (trade_id) REFERENCES trade (id)');
    }
}
