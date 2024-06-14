## Teste MotocaSystems Backend


## Documentação no postman da API:
- https://www.postman.com/ivovilar1/workspace/teste-backend-motoca/collection/21873994-7038fd5d-7c89-4150-abe0-2379d8d1c950?action=share&creator=21873994

## Para rodar o projeto localmente siga os seguintes passos:
-------------------------------------------------------------
Observação:
* Certifique-se de que tenha o php instalado na versão 8.2 superior *
* Certique-se de que tenha o composer instalado *
* Certifique-se de que tenha o postgresql instalado *
-------------------------------------------------------------
 1- Clone este repositorio
 2- Execute o comando para instalar as dependencias do projeto:
 ```sh
composer install
```
3- execute o comando para copiar o env (se precisar, faça os ajustes necessarios de configurações relacionados ao banco)
```sh
cp .env.example .env
```
4- execute o comando para gerar a chave de criptografia do laravel:
```sh
php artisan key:generate
```
5- execute o comando para "startar" a aplicação:
```sh
php artisan serve
```
6- execute o comando para executar as migrações:
```sh
php artisan migrate
```
7- execute o comando para executar popular o banco com dados falsos:
```sh
php artisan db:seed
```

--------------------------------------------------##---------------
## Para rodar os testes da API, execute:
```sh
php artisan test
```
