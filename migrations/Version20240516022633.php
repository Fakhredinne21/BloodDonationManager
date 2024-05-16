<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516022633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, adminbyplace_id INT NOT NULL, date DATE NOT NULL, status TINYINT(1) NOT NULL, name_activity VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_AC74095AA67710EA (adminbyplace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_donor (activity_id INT NOT NULL, donor_id INT NOT NULL, INDEX IDX_C9F0762481C06096 (activity_id), INDEX IDX_C9F076243DD7B7A7 (donor_id), PRIMARY KEY(activity_id, donor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_nurse (activity_id INT NOT NULL, nurse_id INT NOT NULL, INDEX IDX_CC7C5BF081C06096 (activity_id), INDEX IDX_CC7C5BF07373BFAA (nurse_id), PRIMARY KEY(activity_id, nurse_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, last_name VARCHAR(60) NOT NULL, first_name VARCHAR(60) NOT NULL, password VARCHAR(255) NOT NULL, phone NUMERIC(10, 2) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adminbyplace (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, last_name VARCHAR(60) NOT NULL, first_name VARCHAR(60) NOT NULL, password VARCHAR(255) NOT NULL, phone NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_BBACAC11A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blood (id INT AUTO_INCREMENT NOT NULL, quantity_blood INT NOT NULL, number_donors VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blood_bank (id INT AUTO_INCREMENT NOT NULL, name_bh VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, phone INT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blood_bank_bloodhoster (blood_bank_id INT NOT NULL, bloodhoster_id INT NOT NULL, INDEX IDX_6BFECEB6AE6E20E0 (blood_bank_id), INDEX IDX_6BFECEB6C300FCA9 (bloodhoster_id), PRIMARY KEY(blood_bank_id, bloodhoster_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blood_category (id INT AUTO_INCREMENT NOT NULL, categ_name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blood_hoster (id INT AUTO_INCREMENT NOT NULL, type_bh VARCHAR(60) NOT NULL, name_bh VARCHAR(60) NOT NULL, location VARCHAR(60) NOT NULL, phone_number NUMERIC(10, 2) NOT NULL, email VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donor (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, participation_id INT DEFAULT NULL, last_name VARCHAR(60) NOT NULL, first_name VARCHAR(60) NOT NULL, password VARCHAR(255) NOT NULL, phone NUMERIC(10, 2) NOT NULL, state INT NOT NULL, blood_type VARCHAR(255) NOT NULL, agree TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D7F24097A76ED395 (user_id), INDEX IDX_D7F240976ACE3B73 (participation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donor_blood_hoster (donor_id INT NOT NULL, blood_hoster_id INT NOT NULL, INDEX IDX_DB0A21663DD7B7A7 (donor_id), INDEX IDX_DB0A2166EAB3B53E (blood_hoster_id), PRIMARY KEY(donor_id, blood_hoster_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nurse (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, last_name VARCHAR(60) NOT NULL, first_name VARCHAR(60) NOT NULL, password VARCHAR(255) NOT NULL, phone NUMERIC(10, 2) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D27E6D43A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, activities_id INT DEFAULT NULL, approved TINYINT(1) NOT NULL, approved_by_nurse TINYINT(1) DEFAULT NULL, INDEX IDX_AB55E24F2A4DB562 (activities_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation_nurse (participation_id INT NOT NULL, nurse_id INT NOT NULL, INDEX IDX_DDA2E0C86ACE3B73 (participation_id), INDEX IDX_DDA2E0C87373BFAA (nurse_id), PRIMARY KEY(participation_id, nurse_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AA67710EA FOREIGN KEY (adminbyplace_id) REFERENCES adminbyplace (id)');
        $this->addSql('ALTER TABLE activity_donor ADD CONSTRAINT FK_C9F0762481C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_donor ADD CONSTRAINT FK_C9F076243DD7B7A7 FOREIGN KEY (donor_id) REFERENCES donor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_nurse ADD CONSTRAINT FK_CC7C5BF081C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_nurse ADD CONSTRAINT FK_CC7C5BF07373BFAA FOREIGN KEY (nurse_id) REFERENCES nurse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE adminbyplace ADD CONSTRAINT FK_BBACAC11A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE blood_bank_bloodhoster ADD CONSTRAINT FK_6BFECEB6AE6E20E0 FOREIGN KEY (blood_bank_id) REFERENCES blood_bank (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blood_bank_bloodhoster ADD CONSTRAINT FK_6BFECEB6C300FCA9 FOREIGN KEY (bloodhoster_id) REFERENCES blood_hoster (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donor ADD CONSTRAINT FK_D7F24097A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE donor ADD CONSTRAINT FK_D7F240976ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id)');
        $this->addSql('ALTER TABLE donor_blood_hoster ADD CONSTRAINT FK_DB0A21663DD7B7A7 FOREIGN KEY (donor_id) REFERENCES donor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donor_blood_hoster ADD CONSTRAINT FK_DB0A2166EAB3B53E FOREIGN KEY (blood_hoster_id) REFERENCES blood_hoster (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nurse ADD CONSTRAINT FK_D27E6D43A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F2A4DB562 FOREIGN KEY (activities_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE participation_nurse ADD CONSTRAINT FK_DDA2E0C86ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participation_nurse ADD CONSTRAINT FK_DDA2E0C87373BFAA FOREIGN KEY (nurse_id) REFERENCES nurse (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AA67710EA');
        $this->addSql('ALTER TABLE activity_donor DROP FOREIGN KEY FK_C9F0762481C06096');
        $this->addSql('ALTER TABLE activity_donor DROP FOREIGN KEY FK_C9F076243DD7B7A7');
        $this->addSql('ALTER TABLE activity_nurse DROP FOREIGN KEY FK_CC7C5BF081C06096');
        $this->addSql('ALTER TABLE activity_nurse DROP FOREIGN KEY FK_CC7C5BF07373BFAA');
        $this->addSql('ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D76A76ED395');
        $this->addSql('ALTER TABLE adminbyplace DROP FOREIGN KEY FK_BBACAC11A76ED395');
        $this->addSql('ALTER TABLE blood_bank_bloodhoster DROP FOREIGN KEY FK_6BFECEB6AE6E20E0');
        $this->addSql('ALTER TABLE blood_bank_bloodhoster DROP FOREIGN KEY FK_6BFECEB6C300FCA9');
        $this->addSql('ALTER TABLE donor DROP FOREIGN KEY FK_D7F24097A76ED395');
        $this->addSql('ALTER TABLE donor DROP FOREIGN KEY FK_D7F240976ACE3B73');
        $this->addSql('ALTER TABLE donor_blood_hoster DROP FOREIGN KEY FK_DB0A21663DD7B7A7');
        $this->addSql('ALTER TABLE donor_blood_hoster DROP FOREIGN KEY FK_DB0A2166EAB3B53E');
        $this->addSql('ALTER TABLE nurse DROP FOREIGN KEY FK_D27E6D43A76ED395');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F2A4DB562');
        $this->addSql('ALTER TABLE participation_nurse DROP FOREIGN KEY FK_DDA2E0C86ACE3B73');
        $this->addSql('ALTER TABLE participation_nurse DROP FOREIGN KEY FK_DDA2E0C87373BFAA');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE activity_donor');
        $this->addSql('DROP TABLE activity_nurse');
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
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE participation_nurse');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
