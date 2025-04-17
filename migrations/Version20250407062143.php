<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250407062143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attachment (id INT AUTO_INCREMENT NOT NULL, original_name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, issue_id INT NOT NULL, INDEX IDX_795FD9BB5E7AA58C (issue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE issue (id INT AUTO_INCREMENT NOT NULL, type SMALLINT NOT NULL, summary VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, story_point_estimate INT DEFAULT NULL, project_id INT NOT NULL, assignee_id INT DEFAULT NULL, reporter_id INT NOT NULL, INDEX IDX_12AD233E166D1F9C (project_id), INDEX IDX_12AD233E59EC7D60 (assignee_id), INDEX IDX_12AD233EE1CFE6F5 (reporter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, key_code VARCHAR(5) NOT NULL, lead_user_id INT NOT NULL, INDEX IDX_2FB3D0EEFEA08FFB (lead_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE project_user (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B4021E51166D1F9C (project_id), INDEX IDX_B4021E51A76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, selected_project_id INT DEFAULT NULL, INDEX IDX_8D93D64921ED5B7F (selected_project_id), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE attachment ADD CONSTRAINT FK_795FD9BB5E7AA58C FOREIGN KEY (issue_id) REFERENCES issue (id)');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E59EC7D60 FOREIGN KEY (assignee_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233EE1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEFEA08FFB FOREIGN KEY (lead_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64921ED5B7F FOREIGN KEY (selected_project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachment DROP FOREIGN KEY FK_795FD9BB5E7AA58C');
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E166D1F9C');
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E59EC7D60');
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233EE1CFE6F5');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEFEA08FFB');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51166D1F9C');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64921ED5B7F');
        $this->addSql('DROP TABLE attachment');
        $this->addSql('DROP TABLE issue');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_user');
        $this->addSql('DROP TABLE user');
    }
}
