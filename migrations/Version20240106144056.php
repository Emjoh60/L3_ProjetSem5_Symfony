<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240106144056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monstre DROP FOREIGN KEY FK_A20EC7A5A3878AD1');
        $this->addSql('ALTER TABLE monstre ADD CONSTRAINT FK_A20EC7A5A3878AD1 FOREIGN KEY (royaume_id) REFERENCES royaume (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A20EC7A56C6E55B5 ON monstre (nom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7D09BAD6C6E55B5 ON royaume (nom)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monstre DROP FOREIGN KEY FK_A20EC7A5A3878AD1');
        $this->addSql('DROP INDEX UNIQ_A20EC7A56C6E55B5 ON monstre');
        $this->addSql('ALTER TABLE monstre ADD CONSTRAINT FK_A20EC7A5A3878AD1 FOREIGN KEY (royaume_id) REFERENCES royaume (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP INDEX UNIQ_D7D09BAD6C6E55B5 ON royaume');
    }
}
