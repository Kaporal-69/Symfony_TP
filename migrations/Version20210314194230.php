<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210314194230 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE magasin_stock');
        $this->addSql('DROP TABLE stock_product');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE magasin_stock (magasin_id INT NOT NULL, stock_id INT NOT NULL, INDEX IDX_1F59585720096AE3 (magasin_id), INDEX IDX_1F595857DCD6110 (stock_id), PRIMARY KEY(magasin_id, stock_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE stock_product (stock_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_CAEC140E4584665A (product_id), INDEX IDX_CAEC140EDCD6110 (stock_id), PRIMARY KEY(stock_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE magasin_stock ADD CONSTRAINT FK_1F59585720096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE magasin_stock ADD CONSTRAINT FK_1F595857DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_product ADD CONSTRAINT FK_CAEC140E4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stock_product ADD CONSTRAINT FK_CAEC140EDCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
