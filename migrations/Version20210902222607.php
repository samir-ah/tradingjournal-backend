<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210902222607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trade_like DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE trade_like ADD author_id INT NOT NULL, DROP user_id, CHANGE trade_id trade_id INT NOT NULL');
        $this->addSql('ALTER TABLE trade_like ADD CONSTRAINT FK_CE983748C2D9760 FOREIGN KEY (trade_id) REFERENCES trade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trade_like ADD CONSTRAINT FK_CE983748F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_CE983748C2D9760 ON trade_like (trade_id)');
        $this->addSql('CREATE INDEX IDX_CE983748F675F31B ON trade_like (author_id)');
        $this->addSql('ALTER TABLE trade_like ADD PRIMARY KEY (trade_id, author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trade_like DROP FOREIGN KEY FK_CE983748C2D9760');
        $this->addSql('ALTER TABLE trade_like DROP FOREIGN KEY FK_CE983748F675F31B');
        $this->addSql('DROP INDEX IDX_CE983748C2D9760 ON trade_like');
        $this->addSql('DROP INDEX IDX_CE983748F675F31B ON trade_like');
        $this->addSql('ALTER TABLE trade_like DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE trade_like ADD user_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP author_id, CHANGE trade_id trade_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE trade_like ADD PRIMARY KEY (trade_id, user_id)');
    }
}
