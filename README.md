
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
