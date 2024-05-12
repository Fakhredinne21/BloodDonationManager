<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240512215521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` DROP email, DROP password, DROP role');
        $this->addSql('ALTER TABLE adminbyplace DROP email, DROP password, DROP role');
        $this->addSql('ALTER TABLE donor DROP email, DROP password, DROP role');
        $this->addSql('ALTER TABLE nurse DROP email, DROP password, DROP role');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE donor ADD email VARCHAR(60) NOT NULL, ADD password VARCHAR(60) NOT NULL, ADD role VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE adminbyplace ADD email VARCHAR(60) NOT NULL, ADD password VARCHAR(60) NOT NULL, ADD role VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE `admin` ADD email VARCHAR(60) NOT NULL, ADD password VARCHAR(60) NOT NULL, ADD role VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE nurse ADD email VARCHAR(60) NOT NULL, ADD password VARCHAR(60) NOT NULL, ADD role VARCHAR(60) NOT NULL');
    }
}
