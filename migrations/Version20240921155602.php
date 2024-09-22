<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240921155602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE img img VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE concert ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE img img VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE lieu ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE img img VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaire ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE img img VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE performance ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE img img VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier DROP updated_at, CHANGE img img LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE concert DROP updated_at, CHANGE img img LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE lieu DROP updated_at, CHANGE img img LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaire DROP updated_at, CHANGE img img LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE performance DROP updated_at, CHANGE img img LONGBLOB DEFAULT NULL');
    }
}
