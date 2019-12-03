<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191203092703 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE product_category');
        $this->addSql('ALTER TABLE product_position ADD product_id INT NOT NULL, ADD category_id INT NOT NULL, ADD position INT NOT NULL');
        $this->addSql('ALTER TABLE product_position ADD CONSTRAINT FK_8D9C8E624584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_position ADD CONSTRAINT FK_8D9C8E6212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_8D9C8E624584665A ON product_position (product_id)');
        $this->addSql('CREATE INDEX IDX_8D9C8E6212469DE2 ON product_position (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_category (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CDFC735612469DE2 (category_id), INDEX IDX_CDFC73564584665A (product_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_position DROP FOREIGN KEY FK_8D9C8E624584665A');
        $this->addSql('ALTER TABLE product_position DROP FOREIGN KEY FK_8D9C8E6212469DE2');
        $this->addSql('DROP INDEX IDX_8D9C8E624584665A ON product_position');
        $this->addSql('DROP INDEX IDX_8D9C8E6212469DE2 ON product_position');
        $this->addSql('ALTER TABLE product_position DROP product_id, DROP category_id, DROP position');
    }
}