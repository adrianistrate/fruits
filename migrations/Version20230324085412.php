<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324085412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fruit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, source_id INT NOT NULL, genus VARCHAR(255) NOT NULL, family VARCHAR(255) NOT NULL, fruit_order VARCHAR(255) NOT NULL, nutritions_carbohydrates NUMERIC(10, 2) NOT NULL, nutritions_protein NUMERIC(10, 2) NOT NULL, nutritions_fat NUMERIC(10, 2) NOT NULL, nutritions_calories NUMERIC(10, 2) NOT NULL, nutritions_sugar NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fruit');
    }
}
