<?php

declare(strict_types=1);

namespace MorgenBord\CoreBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220220091712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_E0AB05ED7E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_widget AS SELECT id, owner_id, parameter_form_fqcn, twig_file, parameters FROM user_widget');
        $this->addSql('DROP TABLE user_widget');
        $this->addSql('CREATE TABLE user_widget (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, parameter_form_fqcn VARCHAR(255) NOT NULL COLLATE BINARY, twig_file VARCHAR(255) NOT NULL COLLATE BINARY, parameters CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , data CLOB DEFAULT NULL --(DC2Type:json)
        , CONSTRAINT FK_E0AB05ED7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_widget (id, owner_id, parameter_form_fqcn, twig_file, parameters) SELECT id, owner_id, parameter_form_fqcn, twig_file, parameters FROM __temp__user_widget');
        $this->addSql('DROP TABLE __temp__user_widget');
        $this->addSql('CREATE INDEX IDX_E0AB05ED7E3C61F9 ON user_widget (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_E0AB05ED7E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_widget AS SELECT id, owner_id, parameter_form_fqcn, twig_file, parameters FROM user_widget');
        $this->addSql('DROP TABLE user_widget');
        $this->addSql('CREATE TABLE user_widget (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, parameter_form_fqcn VARCHAR(255) NOT NULL, twig_file VARCHAR(255) NOT NULL, parameters CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO user_widget (id, owner_id, parameter_form_fqcn, twig_file, parameters) SELECT id, owner_id, parameter_form_fqcn, twig_file, parameters FROM __temp__user_widget');
        $this->addSql('DROP TABLE __temp__user_widget');
        $this->addSql('CREATE INDEX IDX_E0AB05ED7E3C61F9 ON user_widget (owner_id)');
    }
}
