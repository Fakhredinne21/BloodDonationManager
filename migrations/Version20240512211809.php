<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240512211809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE donor_blood_hoster (donor_id INT NOT NULL, blood_hoster_id INT NOT NULL, INDEX IDX_DB0A21663DD7B7A7 (donor_id), INDEX IDX_DB0A2166EAB3B53E (blood_hoster_id), PRIMARY KEY(donor_id, blood_hoster_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE donor_blood_hoster ADD CONSTRAINT FK_DB0A21663DD7B7A7 FOREIGN KEY (donor_id) REFERENCES donor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donor_blood_hoster ADD CONSTRAINT FK_DB0A2166EAB3B53E FOREIGN KEY (blood_hoster_id) REFERENCES blood_hoster (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donor ADD blood_type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE donor_blood_hoster DROP FOREIGN KEY FK_DB0A21663DD7B7A7');
        $this->addSql('ALTER TABLE donor_blood_hoster DROP FOREIGN KEY FK_DB0A2166EAB3B53E');
        $this->addSql('DROP TABLE donor_blood_hoster');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE donor DROP blood_type');
    }
}
