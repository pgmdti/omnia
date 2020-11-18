<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201118142924 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE chamado (id INT AUTO_INCREMENT NOT NULL, departamento_id INT DEFAULT NULL, responsavel INT DEFAULT NULL, criado_por INT DEFAULT NULL, solicitado_por INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, descricao TEXT DEFAULT NULL, status VARCHAR(20) NOT NULL, datacadastro DATE DEFAULT NULL, dataabertura DATE DEFAULT NULL, datafechamento DATE DEFAULT NULL, solucaoadotada TEXT DEFAULT NULL, INDEX IDX_3B02066F5A91C08D (departamento_id), INDEX IDX_3B02066FE1630546 (responsavel), INDEX IDX_3B02066FF69C7D9B (criado_por), INDEX IDX_3B02066FB4CA84BD (solicitado_por), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chamado ADD CONSTRAINT FK_3B02066F5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id)');
        $this->addSql('ALTER TABLE chamado ADD CONSTRAINT FK_3B02066FE1630546 FOREIGN KEY (responsavel) REFERENCES employee (matricula)');
        $this->addSql('ALTER TABLE chamado ADD CONSTRAINT FK_3B02066FF69C7D9B FOREIGN KEY (criado_por) REFERENCES employee (matricula)');
        $this->addSql('ALTER TABLE chamado ADD CONSTRAINT FK_3B02066FB4CA84BD FOREIGN KEY (solicitado_por) REFERENCES employee (matricula)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE chamado');
        $this->addSql('ALTER TABLE ausencia DROP FOREIGN KEY FK_4B573FB104F70C737BB674D');
        $this->addSql('ALTER TABLE ausencia ADD CONSTRAINT FK_4B573FB104F70C737BB674D FOREIGN KEY (employee_cpf, employee_matricula) REFERENCES employee (cpf, matricula) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
