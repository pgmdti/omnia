## Requisitos
* PHP 7.1.29
* php-xml

## CRIAR UMA NOVA ENTITY:
`php bin/console make:entity`

## GERAR UMA MIGRATION COM AS ÚLTIMAS ALTERAÇÕES NA ENTITY:
`php bin/console doctrine:migrations:diff`

## EXECUTAR AS MIGRATIONS PENDENTES:
`php bin/console doctrine:migrations:migrate`

## MOSTRAR O STATUS DAS MIGRATIONS:
`php bin/console doctrine:migrations:status`

## DIZER QUE AS MIGRATIONS FORAM EXECUTADAS (FAKE MIGRATION):
`php bin/console doctrine:migrations:version --add --all`

## RODAR O PROJETO:
`php bin/console serve:run`

## Criando o banco de dados (ainda na pasta do seu projeto criado)
`php bin/console doctrine:database:create`

## Criando as tabelas através das classes mapeadas (ainda na pasta do seu projeto criado)
`php bin/console doctrine:schema:update --force`

# INSTALAR COMPOSER
`sudo apt install composer`

# INSTALAR SYMFONY

## Instalar PHP 7.1 no Ubuntu 16.04 em diante) - testado no Ubuntu 20.04
* `sudo add-apt-repository ppa:ondrej/php`
* `sudo apt-get update`
* `sudo apt-get install -y php7.1`
* `sudo apt-get install php7.1-xml php7.1-curl php7.1-mbstring`
* `sudo apt-get install wget php7.1-cli php7.1-zip zip unzip`
* `wget -O composer-setup.php https://getcomposer.org/installer`
* `sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer`

## Configurando o projeto para desenvolvimento em um novo computador:
* instalar php 7.1 e as extensões necessárias para rodar o projeto
* instalar as dependências do projeto via composer: `composer install`