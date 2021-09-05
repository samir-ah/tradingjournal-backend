<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210902220305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trade (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, trade_instrument_id INT NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_published TINYINT(1) DEFAULT \'0\' NOT NULL, reasons LONGTEXT DEFAULT NULL, outcome LONGTEXT DEFAULT NULL, lesson LONGTEXT DEFAULT NULL, is_good TINYINT(1) DEFAULT NULL, final_ratio NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_7E1A4366F675F31B (author_id), INDEX IDX_7E1A43669D821820 (trade_instrument_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trade_comment (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, trade_id INT NOT NULL, parent_trade_comment_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_67F40A9AF675F31B (author_id), INDEX IDX_67F40A9AC2D9760 (trade_id), INDEX IDX_67F40A9A626654CD (parent_trade_comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trade_image (id INT AUTO_INCREMENT NOT NULL, trade_id INT NOT NULL, image_file VARCHAR(255) NOT NULL, INDEX IDX_EF30D4BCC2D9760 (trade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trade_instrument (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trade_like (trade_id VARCHAR(255) NOT NULL, user_id VARCHAR(255) NOT NULL, liked_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(trade_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A4366F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A43669D821820 FOREIGN KEY (trade_instrument_id) REFERENCES trade_instrument (id)');
        $this->addSql('ALTER TABLE trade_comment ADD CONSTRAINT FK_67F40A9AF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE trade_comment ADD CONSTRAINT FK_67F40A9AC2D9760 FOREIGN KEY (trade_id) REFERENCES trade (id)');
        $this->addSql('ALTER TABLE trade_comment ADD CONSTRAINT FK_67F40A9A626654CD FOREIGN KEY (parent_trade_comment_id) REFERENCES trade_comment (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE trade_image ADD CONSTRAINT FK_EF30D4BCC2D9760 FOREIGN KEY (trade_id) REFERENCES trade (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trade_comment DROP FOREIGN KEY FK_67F40A9AC2D9760');
        $this->addSql('ALTER TABLE trade_image DROP FOREIGN KEY FK_EF30D4BCC2D9760');
        $this->addSql('ALTER TABLE trade_comment DROP FOREIGN KEY FK_67F40A9A626654CD');
        $this->addSql('ALTER TABLE trade DROP FOREIGN KEY FK_7E1A43669D821820');
        $this->addSql('ALTER TABLE trade DROP FOREIGN KEY FK_7E1A4366F675F31B');
        $this->addSql('ALTER TABLE trade_comment DROP FOREIGN KEY FK_67F40A9AF675F31B');
        $this->addSql('DROP TABLE trade');
        $this->addSql('DROP TABLE trade_comment');
        $this->addSql('DROP TABLE trade_image');
        $this->addSql('DROP TABLE trade_instrument');
        $this->addSql('DROP TABLE trade_like');
        $this->addSql('DROP TABLE `user`');
    }
}
