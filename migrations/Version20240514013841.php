<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514013841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(60) NOT NULL, first_name VARCHAR(60) NOT NULL, password VARCHAR(255) NOT NULL, phone NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adminbyplace (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(60) NOT NULL, first_name VARCHAR(60) NOT NULL, password VARCHAR(255) NOT NULL, phone NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blood (id INT AUTO_INCREMENT NOT NULL, quantity_blood INT NOT NULL, number_donors VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blood_bank (id INT AUTO_INCREMENT NOT NULL, name_bh VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, phone INT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blood_bank_bloodhoster (blood_bank_id INT NOT NULL, bloodhoster_id INT NOT NULL, INDEX IDX_6BFECEB6AE6E20E0 (blood_bank_id), INDEX IDX_6BFECEB6C300FCA9 (bloodhoster_id), PRIMARY KEY(blood_bank_id, bloodhoster_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blood_category (id INT AUTO_INCREMENT NOT NULL, categ_name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blood_hoster (id INT AUTO_INCREMENT NOT NULL, type_bh VARCHAR(60) NOT NULL, name_bh VARCHAR(60) NOT NULL, location VARCHAR(60) NOT NULL, phone_number NUMERIC(10, 2) NOT NULL, email VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donor (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, last_name VARCHAR(60) NOT NULL, first_name VARCHAR(60) NOT NULL, password VARCHAR(255) NOT NULL, phone NUMERIC(10, 2) NOT NULL, state INT NOT NULL, blood_type VARCHAR(255) NOT NULL, agree TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D7F24097A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donor_blood_hoster (donor_id INT NOT NULL, blood_hoster_id INT NOT NULL, INDEX IDX_DB0A21663DD7B7A7 (donor_id), INDEX IDX_DB0A2166EAB3B53E (blood_hoster_id), PRIMARY KEY(donor_id, blood_hoster_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nurse (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(60) NOT NULL, first_name VARCHAR(60) NOT NULL, password VARCHAR(255) NOT NULL, phone NUMERIC(10, 2) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blood_bank_bloodhoster ADD CONSTRAINT FK_6BFECEB6AE6E20E0 FOREIGN KEY (blood_bank_id) REFERENCES blood_bank (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blood_bank_bloodhoster ADD CONSTRAINT FK_6BFECEB6C300FCA9 FOREIGN KEY (bloodhoster_id) REFERENCES blood_hoster (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donor ADD CONSTRAINT FK_D7F24097A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE donor_blood_hoster ADD CONSTRAINT FK_DB0A21663DD7B7A7 FOREIGN KEY (donor_id) REFERENCES donor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donor_blood_hoster ADD CONSTRAINT FK_DB0A2166EAB3B53E FOREIGN KEY (blood_hoster_id) REFERENCES blood_hoster (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blood_bank_bloodhoster DROP FOREIGN KEY FK_6BFECEB6AE6E20E0');
        $this->addSql('ALTER TABLE blood_bank_bloodhoster DROP FOREIGN KEY FK_6BFECEB6C300FCA9');
        $this->addSql('ALTER TABLE donor DROP FOREIGN KEY FK_D7F24097A76ED395');
        $this->addSql('ALTER TABLE donor_blood_hoster DROP FOREIGN KEY FK_DB0A21663DD7B7A7');
        $this->addSql('ALTER TABLE donor_blood_hoster DROP FOREIGN KEY FK_DB0A2166EAB3B53E');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE adminbyplace');
        $this->addSql('DROP TABLE blood');
        $this->addSql('DROP TABLE blood_bank');
        $this->addSql('DROP TABLE blood_bank_bloodhoster');
        $this->addSql('DROP TABLE blood_category');
        $this->addSql('DROP TABLE blood_hoster');
        $this->addSql('DROP TABLE donor');
        $this->addSql('DROP TABLE donor_blood_hoster');
        $this->addSql('DROP TABLE nurse');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
