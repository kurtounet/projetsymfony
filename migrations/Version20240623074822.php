<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623074822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP num_adress, DROP adress, DROP city, DROP country, DROP zipcode, DROP latitude, DROP longitude');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD num_adress SMALLINT DEFAULT NULL, ADD adress VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(50) DEFAULT NULL, ADD country VARCHAR(10) DEFAULT NULL, ADD zipcode VARCHAR(6) DEFAULT NULL, ADD latitude VARCHAR(255) DEFAULT NULL, ADD longitude VARCHAR(255) DEFAULT NULL');
    }
}
