### Requisitos para rodar o projeto localmente: PHP 7.1.29 instalado (mesma versão do VPS)

## CRIAR UMA NOVA ENTITY:
php bin/console make:entity

## GERAR UMA MIGRATION COM AS ÚLTIMAS ALTERAÇÕES NA ENTITY:
php bin/console doctrine:migrations:diff

## EXECUTAR AS MIGRATIONS PENDENTES:
php bin/console doctrine:migrations:migrate

## MOSTRAR O STATUS DAS MIGRATIONS:
php bin/console doctrine:migrations:status

## DIZER QUE AS MIGRATIONS FORAM EXECUTADAS (FAKE MIGRATION):
php bin/console doctrine:migrations:version --add --all

## RODAR O PROJETO:
php bin/console serve:run





## Criando o banco de dados (ainda na pasta do seu projeto criado)
php bin/console doctrine:database:create

## Criando as tabelas através das classes mapeadas (ainda na pasta do seu projeto criado)
php bin/console doctrine:schema:update --force

# INSTALAR COMPOSER
# INSTALAR SYMFONY

