<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231225193728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aluno (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE curso (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE curso_aluno (curso_id INTEGER NOT NULL, aluno_id INTEGER NOT NULL, PRIMARY KEY(curso_id, aluno_id), CONSTRAINT FK_6F96721A87CB4A1F FOREIGN KEY (curso_id) REFERENCES curso (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6F96721AB2DDF7F4 FOREIGN KEY (aluno_id) REFERENCES aluno (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6F96721A87CB4A1F ON curso_aluno (curso_id)');
        $this->addSql('CREATE INDEX IDX_6F96721AB2DDF7F4 ON curso_aluno (aluno_id)');
        $this->addSql('CREATE TABLE telefone (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, aluno_id INTEGER NOT NULL, numero VARCHAR(11) NOT NULL, CONSTRAINT FK_2132E361B2DDF7F4 FOREIGN KEY (aluno_id) REFERENCES aluno (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2132E361B2DDF7F4 ON telefone (aluno_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE aluno');
        $this->addSql('DROP TABLE curso');
        $this->addSql('DROP TABLE curso_aluno');
        $this->addSql('DROP TABLE telefone');
    }
}
