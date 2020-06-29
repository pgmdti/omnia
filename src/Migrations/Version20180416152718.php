<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180416152718 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ausencia CHANGE tipoausencia_id tipoausencia_id INT DEFAULT NULL, CHANGE employeeausencia_id employeeausencia_id INT DEFAULT NULL, CHANGE dataini dataini DATE DEFAULT NULL, CHANGE datafim datafim DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE cidade CHANGE ufid ufid INT DEFAULT NULL');
        $this->addSql('ALTER TABLE documento ADD ausencia_id INT DEFAULT NULL, CHANGE employee_id employee_id INT DEFAULT NULL, CHANGE path path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC760C93433 FOREIGN KEY (ausencia_id) REFERENCES ausencia (id)');
        $this->addSql('CREATE INDEX IDX_B6B12EC760C93433 ON documento (ausencia_id)');
        $this->addSql('ALTER TABLE employee CHANGE classificacao_id classificacao_id INT DEFAULT NULL, CHANGE departamento_id departamento_id INT DEFAULT NULL, CHANGE orgao_id orgao_id INT DEFAULT NULL, CHANGE cidade_id cidade_id INT DEFAULT NULL, CHANGE estado_id estado_id INT DEFAULT NULL, CHANGE cidadenatu_id cidadenatu_id INT DEFAULT NULL, CHANGE estadoeleitor_id estadoeleitor_id INT DEFAULT NULL, CHANGE estadocivil_id estadocivil_id INT DEFAULT NULL, CHANGE estadorg_id estadorg_id INT DEFAULT NULL, CHANGE estadonatu_id estadonatu_id INT DEFAULT NULL, CHANGE escolaridade_id escolaridade_id INT DEFAULT NULL, CHANGE nome nome VARCHAR(255) DEFAULT NULL, CHANGE endereco endereco VARCHAR(255) DEFAULT NULL, CHANGE numero numero VARCHAR(10) DEFAULT NULL, CHANGE bairro bairro VARCHAR(255) DEFAULT NULL, CHANGE cep cep VARCHAR(9) DEFAULT NULL, CHANGE fone fone VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE mae mae VARCHAR(255) DEFAULT NULL, CHANGE pai pai VARCHAR(255) DEFAULT NULL, CHANGE especializacoes especializacoes VARCHAR(255) DEFAULT NULL, CHANGE datanascimento datanascimento DATE DEFAULT NULL, CHANGE sexo sexo VARCHAR(255) DEFAULT NULL, CHANGE cnh cnh VARCHAR(20) DEFAULT NULL, CHANGE categoria categoria VARCHAR(2) DEFAULT NULL, CHANGE rg rg VARCHAR(20) DEFAULT NULL, CHANGE orgaoemissor orgaoemissor VARCHAR(140) DEFAULT NULL, CHANGE dataemissao dataemissao DATE DEFAULT NULL, CHANGE cpf cpf VARCHAR(20) DEFAULT NULL, CHANGE pispasep pispasep VARCHAR(30) DEFAULT NULL, CHANGE oab oab VARCHAR(30) DEFAULT NULL, CHANGE ctps ctps VARCHAR(20) DEFAULT NULL, CHANGE seriectps seriectps VARCHAR(20) DEFAULT NULL, CHANGE cermil cermil VARCHAR(20) DEFAULT NULL, CHANGE seriecertmil seriecertmil VARCHAR(20) DEFAULT NULL, CHANGE titulo titulo VARCHAR(20) DEFAULT NULL, CHANGE secao secao VARCHAR(5) DEFAULT NULL, CHANGE zona zona VARCHAR(5) DEFAULT NULL, CHANGE banco banco VARCHAR(50) DEFAULT NULL, CHANGE agencia agencia VARCHAR(10) DEFAULT NULL, CHANGE conta conta VARCHAR(20) DEFAULT NULL, CHANGE dataposse dataposse DATE DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ausencia CHANGE tipoausencia_id tipoausencia_id INT DEFAULT NULL, CHANGE employeeausencia_id employeeausencia_id INT DEFAULT NULL, CHANGE dataini dataini DATE DEFAULT \'NULL\', CHANGE datafim datafim DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE cidade CHANGE ufid ufid INT DEFAULT NULL');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC760C93433');
        $this->addSql('DROP INDEX IDX_B6B12EC760C93433 ON documento');
        $this->addSql('ALTER TABLE documento DROP ausencia_id, CHANGE employee_id employee_id INT DEFAULT NULL, CHANGE path path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE employee CHANGE classificacao_id classificacao_id INT DEFAULT NULL, CHANGE cidade_id cidade_id INT DEFAULT NULL, CHANGE estado_id estado_id INT DEFAULT NULL, CHANGE escolaridade_id escolaridade_id INT DEFAULT NULL, CHANGE estadocivil_id estadocivil_id INT DEFAULT NULL, CHANGE cidadenatu_id cidadenatu_id INT DEFAULT NULL, CHANGE estadonatu_id estadonatu_id INT DEFAULT NULL, CHANGE estadorg_id estadorg_id INT DEFAULT NULL, CHANGE estadoeleitor_id estadoeleitor_id INT DEFAULT NULL, CHANGE departamento_id departamento_id INT DEFAULT NULL, CHANGE orgao_id orgao_id INT DEFAULT NULL, CHANGE nome nome VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE endereco endereco VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE numero numero VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE bairro bairro VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE cep cep VARCHAR(9) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE fone fone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE mae mae VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE pai pai VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE especializacoes especializacoes VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE datanascimento datanascimento DATE DEFAULT \'NULL\', CHANGE sexo sexo VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE cnh cnh VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE categoria categoria VARCHAR(2) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE rg rg VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE orgaoemissor orgaoemissor VARCHAR(140) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE dataemissao dataemissao DATE DEFAULT \'NULL\', CHANGE cpf cpf VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE pispasep pispasep VARCHAR(30) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE oab oab VARCHAR(30) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE ctps ctps VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE seriectps seriectps VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE cermil cermil VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE seriecertmil seriecertmil VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE titulo titulo VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE secao secao VARCHAR(5) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE zona zona VARCHAR(5) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE banco banco VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE agencia agencia VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE conta conta VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE dataposse dataposse DATE DEFAULT \'NULL\'');
    }
}
