<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240622134320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034A25E9820 FOREIGN KEY (planet_id) REFERENCES planet (id)');
        $this->addSql('ALTER TABLE user ADD zipcode VARCHAR(6) DEFAULT NULL, ADD latitude VARCHAR(255) DEFAULT NULL, ADD longitude VARCHAR(255) DEFAULT NULL, CHANGE num_adress num_adress SMALLINT DEFAULT NULL, CHANGE adress adress VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(50) DEFAULT NULL, CHANGE country country VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64988D46F62 FOREIGN KEY (character_pref_id) REFERENCES `character` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB034A25E9820');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64988D46F62');
        $this->addSql('ALTER TABLE user DROP zipcode, DROP latitude, DROP longitude, CHANGE num_adress num_adress SMALLINT NOT NULL, CHANGE adress adress VARCHAR(255) NOT NULL, CHANGE city city VARCHAR(50) NOT NULL, CHANGE country country VARCHAR(10) NOT NULL');
    }
}
