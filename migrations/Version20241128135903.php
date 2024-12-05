<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241128135903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Location (id INT AUTO_INCREMENT NOT NULL, lat NUMERIC(20, 16) NOT NULL, lng NUMERIC(20, 16) NOT NULL, name VARCHAR(250) NOT NULL, icon LONGBLOB DEFAULT NULL, icon_size INT DEFAULT NULL, icon_anchor INT DEFAULT NULL, content VARCHAR(6000) DEFAULT NULL, begin_datetime DATETIME DEFAULT NULL, end_datetime DATETIME DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', type_de_lieu VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('ALTER TABLE atelier ADD Location_id INT NOT NULL, DROP lieu');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB182364D218E FOREIGN KEY (Location_id) REFERENCES Location (id)');
        $this->addSql('CREATE INDEX IDX_E1BB182364D218E ON atelier (Location_id)');
        $this->addSql('ALTER TABLE concert ADD Location_id INT DEFAULT NULL, DROP lieu');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D264D218E FOREIGN KEY (Location_id) REFERENCES Location (id)');
        $this->addSql('CREATE INDEX IDX_D57C02D264D218E ON concert (Location_id)');
        $this->addSql('ALTER TABLE performance DROP lieu');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB182364D218E');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D264D218E');
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, content VARCHAR(6000) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, begin_datetime DATETIME DEFAULT NULL, end_datetime DATETIME DEFAULT NULL, img VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', type_de_lieu VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE Location');
        $this->addSql('DROP INDEX IDX_E1BB182364D218E ON atelier');
        $this->addSql('ALTER TABLE atelier ADD lieu VARCHAR(20) DEFAULT NULL, DROP Location_id');
        $this->addSql('DROP INDEX IDX_D57C02D264D218E ON concert');
        $this->addSql('ALTER TABLE concert ADD lieu VARCHAR(20) DEFAULT NULL, DROP Location_id');
        $this->addSql('ALTER TABLE performance ADD lieu VARCHAR(20) DEFAULT NULL');
    }
}
