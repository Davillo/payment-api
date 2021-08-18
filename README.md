## Dependências
- Apenas Docker instalado

## Instalação e Configuração
- Clone ou faça o download deste repositório
- Execute `cp .env.example .env` 
- Execute `docker-compose up -d` para buildar e criar os containers
- Execute `docker exec -it "container_aplicação" composer install` para instalar todas as dependências e libs
- Execute `docker exec -it "container_aplicação" php artisan migrate` executar as migrações do DB
- E, Execute `docker exec -it app "container_aplicação" php artisan db:seed` para popular as tabelas

## Documentação
Os endpoints e retornos estão documentados no arquivo payment-api.json dentro da pasta /apidoc
sendo necessário apenas importar esse arquivo json dentro de um HTTP Client como Postman ou Insomnia.

## Execução
Atentar apenas a portas sendo usadas na maquina se não são as mesmas que o docker usa.

## Testes
executar comando: docker exec -it "container_aplicação" vendor/bin/phpunit  
