<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230414114116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE about (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE abstract_page (id INT AUTO_INCREMENT NOT NULL, navigation_id INT DEFAULT NULL, subnavigation_id INT DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, style LONGTEXT DEFAULT NULL, is_visible TINYINT(1) NOT NULL, tags LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, language_code VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E7EEC52139F79D6D (navigation_id), UNIQUE INDEX UNIQ_E7EEC52174FEB8F2 (subnavigation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE abstract_page_section (abstract_page_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_4478284BAEF10574 (abstract_page_id), INDEX IDX_4478284BD823E37A (section_id), PRIMARY KEY(abstract_page_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chain (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', description LONGTEXT DEFAULT NULL, style LONGTEXT DEFAULT NULL, is_visible TINYINT(1) NOT NULL, position SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, language_code VARCHAR(255) NOT NULL, INDEX IDX_B10218CAD823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `column` (id INT AUTO_INCREMENT NOT NULL, chain_id INT DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', position SMALLINT NOT NULL, is_visible TINYINT(1) NOT NULL, style LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, language_code VARCHAR(255) NOT NULL, INDEX IDX_7D53877E966C2F62 (chain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_profile (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', company_name VARCHAR(255) NOT NULL, company_address VARCHAR(255) DEFAULT NULL, company_contact VARCHAR(255) DEFAULT NULL, company_query_email VARCHAR(255) DEFAULT NULL, company_sales_email VARCHAR(255) DEFAULT NULL, company_description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, column_id INT DEFAULT NULL, content_kind_id INT DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', position SMALLINT NOT NULL, resource LONGTEXT NOT NULL, description LONGTEXT DEFAULT NULL, is_visible TINYINT(1) NOT NULL, style LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, language_code VARCHAR(255) NOT NULL, INDEX IDX_FEC530A9BE8E8ED5 (column_id), INDEX IDX_FEC530A9EF68F51A (content_kind_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_kind (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', type VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_update (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', current_navigation_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', current_subnavigation_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', current_abstract_page_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', current_section_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', current_chain_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', current_column_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', current_content_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', previous_navigation_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', previous_subnavigation_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', previous_abstract_page_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', previous_section_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', previous_chain_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', previous_column_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', previous_content_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE external_user (id INT NOT NULL, email VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_188CB665E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE internal_activity (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', description LONGTEXT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE internal_user (id INT NOT NULL, internal_activity_id INT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_61134782E7927C74 (email), UNIQUE INDEX UNIQ_61134782B4AF2013 (internal_activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', media_type VARCHAR(255) DEFAULT NULL, file_name LONGTEXT DEFAULT NULL, file_type LONGTEXT DEFAULT NULL, position SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_section (media_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_4CA4FCA6EA9FDD75 (media_id), INDEX IDX_4CA4FCA6D823E37A (section_id), PRIMARY KEY(media_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_abstract_page (media_id INT NOT NULL, abstract_page_id INT NOT NULL, INDEX IDX_389FB80EA9FDD75 (media_id), INDEX IDX_389FB80AEF10574 (abstract_page_id), PRIMARY KEY(media_id, abstract_page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_navigation (media_id INT NOT NULL, navigation_id INT NOT NULL, INDEX IDX_431F0BABEA9FDD75 (media_id), INDEX IDX_431F0BAB39F79D6D (navigation_id), PRIMARY KEY(media_id, navigation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_subnavigation (media_id INT NOT NULL, subnavigation_id INT NOT NULL, INDEX IDX_F2CC1C3DEA9FDD75 (media_id), INDEX IDX_F2CC1C3D74FEB8F2 (subnavigation_id), PRIMARY KEY(media_id, subnavigation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_chain (media_id INT NOT NULL, chain_id INT NOT NULL, INDEX IDX_AE1BDC7BEA9FDD75 (media_id), INDEX IDX_AE1BDC7B966C2F62 (chain_id), PRIMARY KEY(media_id, chain_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_column (media_id INT NOT NULL, column_id INT NOT NULL, INDEX IDX_C12A1DA0EA9FDD75 (media_id), INDEX IDX_C12A1DA0BE8E8ED5 (column_id), PRIMARY KEY(media_id, column_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_content (media_id INT NOT NULL, content_id INT NOT NULL, INDEX IDX_9F12B6E0EA9FDD75 (media_id), INDEX IDX_9F12B6E084A0A3ED (content_id), PRIMARY KEY(media_id, content_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_company_profile (media_id INT NOT NULL, company_profile_id INT NOT NULL, INDEX IDX_D778C4BCEA9FDD75 (media_id), INDEX IDX_D778C4BC7174FB2E (company_profile_id), PRIMARY KEY(media_id, company_profile_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_user (media_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4ED4099AEA9FDD75 (media_id), INDEX IDX_4ED4099AA76ED395 (user_id), PRIMARY KEY(media_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE navigation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, is_visible TINYINT(1) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', style LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, position SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, language_code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_493AC53F2B36786B (title), UNIQUE INDEX UNIQ_493AC53F989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', description LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E04992AAD17F50A6 (uuid), UNIQUE INDEX UNIQ_E04992AA5E237E06 (name), UNIQUE INDEX UNIQ_E04992AA989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission_role (permission_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_6A711CAFED90CCA (permission_id), INDEX IDX_6A711CAD60322AC (role_id), PRIMARY KEY(permission_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', description LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_57698A6AD17F50A6 (uuid), UNIQUE INDEX UNIQ_57698A6A5E237E06 (name), UNIQUE INDEX UNIQ_57698A6A989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, style LONGTEXT DEFAULT NULL, is_visible TINYINT(1) NOT NULL, description LONGTEXT DEFAULT NULL, position SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, language_code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2D737AEF2B36786B (title), UNIQUE INDEX UNIQ_2D737AEF989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subnavigation (id INT AUTO_INCREMENT NOT NULL, navigation_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, is_visible TINYINT(1) NOT NULL, style LONGTEXT DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', position SMALLINT NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, language_code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_16AB229C2B36786B (title), UNIQUE INDEX UNIQ_16AB229C989D9B62 (slug), INDEX IDX_16AB229C39F79D6D (navigation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', firstname VARCHAR(100) NOT NULL, is_deleted TINYINT(1) DEFAULT 0, is_verified TINYINT(1) NOT NULL, last_logged_in_at DATETIME DEFAULT NULL, lastname VARCHAR(100) DEFAULT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(180) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649D17F50A6 (uuid), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_2DE8C6A3A76ED395 (user_id), INDEX IDX_2DE8C6A3D60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE about ADD CONSTRAINT FK_B5F422E3BF396750 FOREIGN KEY (id) REFERENCES abstract_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE abstract_page ADD CONSTRAINT FK_E7EEC52139F79D6D FOREIGN KEY (navigation_id) REFERENCES navigation (id)');
        $this->addSql('ALTER TABLE abstract_page ADD CONSTRAINT FK_E7EEC52174FEB8F2 FOREIGN KEY (subnavigation_id) REFERENCES subnavigation (id)');
        $this->addSql('ALTER TABLE abstract_page_section ADD CONSTRAINT FK_4478284BAEF10574 FOREIGN KEY (abstract_page_id) REFERENCES abstract_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE abstract_page_section ADD CONSTRAINT FK_4478284BD823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143BF396750 FOREIGN KEY (id) REFERENCES abstract_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chain ADD CONSTRAINT FK_B10218CAD823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE `column` ADD CONSTRAINT FK_7D53877E966C2F62 FOREIGN KEY (chain_id) REFERENCES chain (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638BF396750 FOREIGN KEY (id) REFERENCES abstract_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9BE8E8ED5 FOREIGN KEY (column_id) REFERENCES `column` (id)');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9EF68F51A FOREIGN KEY (content_kind_id) REFERENCES content_kind (id)');
        $this->addSql('ALTER TABLE external_user ADD CONSTRAINT FK_188CB665BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783ABF396750 FOREIGN KEY (id) REFERENCES abstract_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE internal_user ADD CONSTRAINT FK_61134782B4AF2013 FOREIGN KEY (internal_activity_id) REFERENCES internal_activity (id)');
        $this->addSql('ALTER TABLE internal_user ADD CONSTRAINT FK_61134782BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_section ADD CONSTRAINT FK_4CA4FCA6EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_section ADD CONSTRAINT FK_4CA4FCA6D823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_abstract_page ADD CONSTRAINT FK_389FB80EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_abstract_page ADD CONSTRAINT FK_389FB80AEF10574 FOREIGN KEY (abstract_page_id) REFERENCES abstract_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_navigation ADD CONSTRAINT FK_431F0BABEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_navigation ADD CONSTRAINT FK_431F0BAB39F79D6D FOREIGN KEY (navigation_id) REFERENCES navigation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_subnavigation ADD CONSTRAINT FK_F2CC1C3DEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_subnavigation ADD CONSTRAINT FK_F2CC1C3D74FEB8F2 FOREIGN KEY (subnavigation_id) REFERENCES subnavigation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_chain ADD CONSTRAINT FK_AE1BDC7BEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_chain ADD CONSTRAINT FK_AE1BDC7B966C2F62 FOREIGN KEY (chain_id) REFERENCES chain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_column ADD CONSTRAINT FK_C12A1DA0EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_column ADD CONSTRAINT FK_C12A1DA0BE8E8ED5 FOREIGN KEY (column_id) REFERENCES `column` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_content ADD CONSTRAINT FK_9F12B6E0EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_content ADD CONSTRAINT FK_9F12B6E084A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_company_profile ADD CONSTRAINT FK_D778C4BCEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_company_profile ADD CONSTRAINT FK_D778C4BC7174FB2E FOREIGN KEY (company_profile_id) REFERENCES company_profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_user ADD CONSTRAINT FK_4ED4099AEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_user ADD CONSTRAINT FK_4ED4099AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620BF396750 FOREIGN KEY (id) REFERENCES abstract_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_role ADD CONSTRAINT FK_6A711CAFED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_role ADD CONSTRAINT FK_6A711CAD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2BF396750 FOREIGN KEY (id) REFERENCES abstract_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subnavigation ADD CONSTRAINT FK_16AB229C39F79D6D FOREIGN KEY (navigation_id) REFERENCES navigation (id)');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about DROP FOREIGN KEY FK_B5F422E3BF396750');
        $this->addSql('ALTER TABLE abstract_page DROP FOREIGN KEY FK_E7EEC52139F79D6D');
        $this->addSql('ALTER TABLE abstract_page DROP FOREIGN KEY FK_E7EEC52174FEB8F2');
        $this->addSql('ALTER TABLE abstract_page_section DROP FOREIGN KEY FK_4478284BAEF10574');
        $this->addSql('ALTER TABLE abstract_page_section DROP FOREIGN KEY FK_4478284BD823E37A');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143BF396750');
        $this->addSql('ALTER TABLE chain DROP FOREIGN KEY FK_B10218CAD823E37A');
        $this->addSql('ALTER TABLE `column` DROP FOREIGN KEY FK_7D53877E966C2F62');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638BF396750');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A9BE8E8ED5');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A9EF68F51A');
        $this->addSql('ALTER TABLE external_user DROP FOREIGN KEY FK_188CB665BF396750');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783ABF396750');
        $this->addSql('ALTER TABLE internal_user DROP FOREIGN KEY FK_61134782B4AF2013');
        $this->addSql('ALTER TABLE internal_user DROP FOREIGN KEY FK_61134782BF396750');
        $this->addSql('ALTER TABLE media_section DROP FOREIGN KEY FK_4CA4FCA6EA9FDD75');
        $this->addSql('ALTER TABLE media_section DROP FOREIGN KEY FK_4CA4FCA6D823E37A');
        $this->addSql('ALTER TABLE media_abstract_page DROP FOREIGN KEY FK_389FB80EA9FDD75');
        $this->addSql('ALTER TABLE media_abstract_page DROP FOREIGN KEY FK_389FB80AEF10574');
        $this->addSql('ALTER TABLE media_navigation DROP FOREIGN KEY FK_431F0BABEA9FDD75');
        $this->addSql('ALTER TABLE media_navigation DROP FOREIGN KEY FK_431F0BAB39F79D6D');
        $this->addSql('ALTER TABLE media_subnavigation DROP FOREIGN KEY FK_F2CC1C3DEA9FDD75');
        $this->addSql('ALTER TABLE media_subnavigation DROP FOREIGN KEY FK_F2CC1C3D74FEB8F2');
        $this->addSql('ALTER TABLE media_chain DROP FOREIGN KEY FK_AE1BDC7BEA9FDD75');
        $this->addSql('ALTER TABLE media_chain DROP FOREIGN KEY FK_AE1BDC7B966C2F62');
        $this->addSql('ALTER TABLE media_column DROP FOREIGN KEY FK_C12A1DA0EA9FDD75');
        $this->addSql('ALTER TABLE media_column DROP FOREIGN KEY FK_C12A1DA0BE8E8ED5');
        $this->addSql('ALTER TABLE media_content DROP FOREIGN KEY FK_9F12B6E0EA9FDD75');
        $this->addSql('ALTER TABLE media_content DROP FOREIGN KEY FK_9F12B6E084A0A3ED');
        $this->addSql('ALTER TABLE media_company_profile DROP FOREIGN KEY FK_D778C4BCEA9FDD75');
        $this->addSql('ALTER TABLE media_company_profile DROP FOREIGN KEY FK_D778C4BC7174FB2E');
        $this->addSql('ALTER TABLE media_user DROP FOREIGN KEY FK_4ED4099AEA9FDD75');
        $this->addSql('ALTER TABLE media_user DROP FOREIGN KEY FK_4ED4099AA76ED395');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620BF396750');
        $this->addSql('ALTER TABLE permission_role DROP FOREIGN KEY FK_6A711CAFED90CCA');
        $this->addSql('ALTER TABLE permission_role DROP FOREIGN KEY FK_6A711CAD60322AC');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2BF396750');
        $this->addSql('ALTER TABLE subnavigation DROP FOREIGN KEY FK_16AB229C39F79D6D');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3A76ED395');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3D60322AC');
        $this->addSql('DROP TABLE about');
        $this->addSql('DROP TABLE abstract_page');
        $this->addSql('DROP TABLE abstract_page_section');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE chain');
        $this->addSql('DROP TABLE `column`');
        $this->addSql('DROP TABLE company_profile');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE content_kind');
        $this->addSql('DROP TABLE content_update');
        $this->addSql('DROP TABLE external_user');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE internal_activity');
        $this->addSql('DROP TABLE internal_user');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE media_section');
        $this->addSql('DROP TABLE media_abstract_page');
        $this->addSql('DROP TABLE media_navigation');
        $this->addSql('DROP TABLE media_subnavigation');
        $this->addSql('DROP TABLE media_chain');
        $this->addSql('DROP TABLE media_column');
        $this->addSql('DROP TABLE media_content');
        $this->addSql('DROP TABLE media_company_profile');
        $this->addSql('DROP TABLE media_user');
        $this->addSql('DROP TABLE navigation');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE permission_role');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE subnavigation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_role');
    }
}
