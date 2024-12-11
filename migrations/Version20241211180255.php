<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211180255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE titre titre VARCHAR(50) DEFAULT NULL, CHANGE content content VARCHAR(20000) DEFAULT NULL');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB182364D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_E1BB182364D218E ON atelier (location_id)');
        $this->addSql('ALTER TABLE concert CHANGE location_id location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_D57C02D264D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_D57C02D264D218E ON concert (location_id)');
        $this->addSql('ALTER TABLE location DROP icon');
        $this->addSql('ALTER TABLE performance ADD location_id INT DEFAULT NULL, DROP lieu');
        $this->addSql('ALTER TABLE performance ADD CONSTRAINT FK_82D7968164D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_82D7968164D218E ON performance (location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE titre titre VARCHAR(30) DEFAULT NULL, CHANGE content content VARCHAR(6000) DEFAULT NULL');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB182364D218E');
        $this->addSql('DROP INDEX IDX_E1BB182364D218E ON atelier');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_D57C02D264D218E');
        $this->addSql('DROP INDEX IDX_D57C02D264D218E ON concert');
        $this->addSql('ALTER TABLE concert CHANGE location_id location_id VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE location ADD icon LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE performance DROP FOREIGN KEY FK_82D7968164D218E');
        $this->addSql('DROP INDEX IDX_82D7968164D218E ON performance');
        $this->addSql('ALTER TABLE performance ADD lieu VARCHAR(20) DEFAULT NULL, DROP location_id');
    }
}
