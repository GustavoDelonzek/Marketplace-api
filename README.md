
# Marketplace API

Esta é uma API RESTful desenvolvida em Laravel para um Marketplace Genérico, com recursos típicos de uma plataforma de e-commerce. A API permite cadastro de usuários, gerenciamento de produtos, carrinho, pedidos, descontos e cupons.

O projeto segue um sistema de perfis de usuário com permissões específicas: CLIENT, MODERATOR e ADMIN.

## Instalação

Dependências

- Docker ```v28.0.1```

Suba os containers:
```
docker compose up --build -d
```
Copie o arquivo .env:
```
cp src/.env.example src/.env
```

Acesse o terminal do container:
```
docker compose exec --user 1000:1000 php sh
```
Instale as dependências e configure o projeto:

```
composer update
php artisan key:generate
php artisan migrate
``` 

## Rodando os seeders

Para rodar os seeders, rode o comando a seguir:

```bash
  php artisan db:seed
```

Ao rodar esse comando, irá popular as seguintes tabelas:

- Addresses
- Categories
- Coupons
- Discounts
- Products
- Users
## Documentação

Para entender todas as funcionalidades e rotas, acesse a documentação [aqui](https://github.com/GustavoDelonzek/Marketplace-api/blob/main/src/README.md).

