<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515195742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity_donor (activity_id INT NOT NULL, donor_id INT NOT NULL, INDEX IDX_C9F0762481C06096 (activity_id), INDEX IDX_C9F076243DD7B7A7 (donor_id), PRIMARY KEY(activity_id, donor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_donor ADD CONSTRAINT FK_C9F0762481C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_donor ADD CONSTRAINT FK_C9F076243DD7B7A7 FOREIGN KEY (donor_id) REFERENCES donor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `admin` ADD user_id INT NOT NULL, ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76A76ED395 ON `admin` (user_id)');
        $this->addSql('ALTER TABLE nurse ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE nurse ADD CONSTRAINT FK_D27E6D43A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D27E6D43A76ED395 ON nurse (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity_donor DROP FOREIGN KEY FK_C9F0762481C06096');
        $this->addSql('ALTER TABLE activity_donor DROP FOREIGN KEY FK_C9F076243DD7B7A7');
        $this->addSql('DROP TABLE activity_donor');
        $this->addSql('ALTER TABLE nurse DROP FOREIGN KEY FK_D27E6D43A76ED395');
        $this->addSql('DROP INDEX UNIQ_D27E6D43A76ED395 ON nurse');
        $this->addSql('ALTER TABLE nurse DROP user_id');
        $this->addSql('ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D76A76ED395');
        $this->addSql('DROP INDEX UNIQ_880E0D76A76ED395 ON `admin`');
        $this->addSql('ALTER TABLE `admin` DROP user_id, DROP email');
    }
}
