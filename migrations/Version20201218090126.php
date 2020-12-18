<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218090126 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE magasin_stock (magasin_id INT NOT NULL, stock_id INT NOT NULL, INDEX IDX_1F59585720096AE3 (magasin_id), INDEX IDX_1F595857DCD6110 (stock_id), PRIMARY KEY(magasin_id, stock_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE magasin_stock ADD CONSTRAINT FK_1F59585720096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE magasin_stock ADD CONSTRAINT FK_1F595857DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE magasin_stock');
    }
}
