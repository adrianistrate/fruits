<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324115429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fruit ADD family_id INT NOT NULL AFTER id');
        $this->addSql('ALTER TABLE fruit ADD CONSTRAINT FK_A00BD297C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('CREATE INDEX IDX_A00BD297C35E566A ON fruit (family_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fruit DROP FOREIGN KEY FK_A00BD297C35E566A');
        $this->addSql('DROP INDEX IDX_A00BD297C35E566A ON fruit');
        $this->addSql('ALTER TABLE fruit DROP family_id');
    }
}
