# Documentação Marketplace API  

## Sumário 
### 1. Autenticação
- [Registrar usuário](#registrar-usuário)
- [Login](#login)
- [Verificação de email](#verificação-de-email)
- [Reenviar email de verificação](#reenviar-email-de-verificação)
- [Enviar email de recuperação de senha](#enviar-email-de-recuperação-de-senha)
- [Validar token de recuperação de senha](#validar-token-de-recuperação-de-senha)
- [Criar um moderador](#criar-um-moderador)
### 2. Perfil do usuário
- [Ver seu perfil](#ver-seu-perfil)
- [Atualizar seu perfil](#atualizar-seu-perfil)
- [Deletar seu perfil](#deletar-seu-perfil)
- [Atualizar imagem de perfil](#atualizar-imagem-de-perfil)
- [Exibir imagem de perfil](#exibir-imagem-de-perfil)
### 3. Endereços
- [Listar todos os endereços do usuário](#listar-todos-os-endereços-do-usuário)
- [Retornar apenas um endereço do usuário](#retornar-apenas-um-endereço-do-usuário)
- [Criar um endereço do usuário](#criar-um-endereço-do-usuário)
- [Atualizar um endereço do usuário](#atualizar-um-endereço-do-usuário) 
- [Deletar um endereço do usuário](#deletar-um-endereço-do-usuário)
### 4. Categorias
- [Listar todas categorias](#listar-todas-categorias)
- [Retornar apenas uma categoria](#retornar-apenas-uma-categoria)
- [Criar uma categoria](#criar-uma-categoria)
- [Atualizar uma categoria](#atualizar-uma-categoria)
- [Deletar uma categoria](#deletar-uma-categoria)
### 5. Produtos
- [Listar todos os produtos](#listar-todos-os-produtos)
- [Retornar apenas um produto](#retornar-apenas-um-produto)
- [Criar um produto](#criar-um-produto)
- [Atualizar um produto](#atualizar-um-produto)
- [Atualizar estoque de um produto](#atualizar-estoque-de-um-produto)
- [Atualizar imagem de um produto](#atualizar-imagem-de-um-produto)
- [Deletar um produto](#deletar-um-produto)

### 6. Discounts
- [Listar todos os descontos](#listar-todos-os-descontos)
- [Retornar apenas um desconto](#retornar-apenas-um-desconto)
- [Criar um desconto](#criar-um-desconto)
- [Atualizar um desconto](#atualizar-um-desconto)
- [Deletar um desconto](#deletar-um-desconto)

### 7. Coupons
- [Listar todos os cupons](#listar-todos-os-cupons)
- [Retornar apenas um cupon](#retornar-apenas-um-cupon)
- [Criar um cupon](#criar-um-cupon)
- [Atualizar um cupon](#atualizar-um-cupon)
- [Deletar um cupon](#deletar-um-cupon)
- [Retornar cupons desativados](#retornar-cupons-desativados)
- [Renovar um cupon](#renovar-um-cupon)

### 8. Cart
- [Ver carrinho do usuário](#ver-carrinho-do-usuário)
- [Ver itens do carrinho do usuário](#ver-itens-do-carrinho-do-usuário)
- [Atualizar quantidade de um item do carrinho do usuário](#atualizar-quantidade-de-um-item-do-carrinho-do-usuário)
- [Deletar um item do carrinho do usuário](#deletar-um-item-do-carrinho-do-usuário)
- [Limpar o carrinho do usuário](#limpar-o-carrinho-do-usuário)

### 9. Orders
- [Listar todos os pedidos](#listar-todos-os-pedidos)
- [Retornar apenas um pedido](#retornar-apenas-um-pedido)
- [Criar um pedido](#criar-um-pedido)
- [Cancelar um pedido](#cancelar-um-pedido)
- [Alterar status de um pedido](#alterar-status-de-um-pedido)

## Banco de dados

Segue abaixo o esquema do banco de dados:

![Exemplo](public/doc-images/database-schema.png)


---
## Autenticação

### Registrar usuário
```http
POST /api/register
```
#### Não requer autenticação

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `name`         | `string` | **Obrigatório**. Nome do usuário   |
| `email`        | `string` | **Obrigatório**. Email válido       |
| `password`     | `string` | **Obrigatório**. Senha segura       |
| `password_confirmation` | `string` | **Obrigatório**. Confirmação da senha |

### Login
```http
POST /api/login
```
#### Não requer autenticação


| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `email`        | `string` | **Obrigatório**. Email cadastrado   |
| `password`     | `string` | **Obrigatório**. Senha              |


### Verificação de email
```http
GET /api/email/verify/{id}/{hash}
```
#### Requer autenticação(token)


| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | ID do usuário               |
| `hash`    | `string` | Hash de verificação         |

### Reenviar email de verificação
```http
POST /api/email/verification-notification
```
#### Requer autenticação(token)


### Enviar email de recuperação de senha
```http
POST /api/password/forgot-password
```
#### Requer autenticação(token)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `email`        | `string` | **Obrigatório**.


### Validar token de recuperação de senha
```http
POST /api/password/reset-password
```
#### Requer autenticação(token)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `token`        | `string` | **Obrigatório**.|
| `email`        | `string` | **Obrigatório**.|
| `password`     | `string` | **Obrigatório**.|
| `password_confirmation` | `string` | **Obrigatório**.|

### Criar um moderador
```http
POST /api/users/create-moderator
```
#### Requer autenticação (ADMIN)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `name`         | `string` | **Obrigatório**.|
| `email`        | `string` | **Obrigatório**.|
| `password`     | `string` | **Obrigatório**.|
| `password_confirmation` | `string` | **Obrigatório**.|



---
## User Profile
### Ver seu perfil
```http
GET /api/users/me
```
#### Requer autenticação (CLIENT)

#### Retorna
```json
{
    "data": {
        "id": 1,
        "name": "Gustavo Delonze",
        "email": "gustavo@gmail.com",
        "image_path": "public/users/1.jpg",
        "role": "client",
    }
}
```

Pode obter os endereços, pedidos, carrinho e produtos relacionados, basta utilizar o "include" no endpoint. Ver possiveis relações no service ```UserService.php```.

### Atualizar seu perfil

```http
PUT /api/users/me   
```

#### Requer autenticação (CLIENT)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `name`         | `string` | **Não obrigatório**.| 
| `email`        | `string` | **Não obrigatório**.|


### Deletar seu perfil
```http
DELETE /api/users/me
```

#### Requer autenticação (CLIENT)


### Atualizar imagem de perfil
```http
POST /api/users/image
```

#### Requer autenticação (CLIENT)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ | 
| `image`        | `file` | **Obrigatório**.|

### Exibir imagem de perfil
```http
GET /api/users/image
```
#### Requer autenticação (CLIENT)

#### Retorna
Retorna imagem do perfil.

---
## Endereços 

### Listar todos os endereços do usuário

```http
GET /api/addresses
```
#### Requer autenticação (CLIENT)
#### Retorna
```json
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "street": "Rua do pao",
            "number": "123",
            "zip": "12345678",
            "city": "São Paulo",
            "state": "SP",
            "country": "Brasil",
        },
        ...
    ]
}
```

### Retornar apenas um endereço do usuário
```http
GET /api/addresses/{id}
```
#### Requer autenticação (CLIENT)

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | **Obrigatório**.

#### Retorna
```json
{
    "id": 1,
    "user_id": 1,
    "street": "Rua do pao",
    "number": "123",
    "zip": "12345678",
    "city": "São Paulo",
    "state": "SP",
    "country": "Brasil",
}
```

### Criar um endereço do usuário
```http
POST /api/addresses
```
#### Requer autenticação (CLIENT)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `street`        | `string` | **Obrigatório**.|
| `number`        | `string` | **Obrigatório**.|
| `zip`        | `string` | **Obrigatório**.|
| `city`        | `string` | **Obrigatório**.|
| `state`        | `string` | **Obrigatório**.|
| `country`        | `string` | **Obrigatório**.|

### Atualizar um endereço do usuário
```http
PUT /api/addresses/{id}
```
#### Requer autenticação (CLIENT)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `id`           | `int`    | **Obrigatório**.|
| `street`        | `string` | **Não obrigatório**.|
| `number`        | `string` | **Não obrigatório**.|
| `zip`        | `string` | **Não obrigatório**.|
| `city`        | `string` | **Não obrigatório**.|
| `state`        | `string` | **Não obrigatório**.|
| `country`        | `string` | **Não obrigatório**.|

### Deletar um endereço do usuário
```http
DELETE /api/addresses/{id}
```
#### Requer autenticação (CLIENT)

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | **Obrigatório**.

---
## Categorias


### Listar todas categorias
```http
GET /api/categories
```
#### Não requer autenticação
#### Retorna
```json
[
    {
        "id": 1,
        "name": "Bebê",
        "description": "Bebê de laranja",
        "image_path": "public/categories/1.jpg"
    },
    {
        "id": 2,
        "name": "Sala",
        "description": "Sala de verde",
        "image_path": "public/categories/2.jpg"
    }
]
```

Para obter os produtos relacionados as categorias, basta utilizar o "include" no endpoint.

```http
GET /api/categories?include=products
```
#### Retorna
```json
{
    "data": [
        {
            "id": 1,
            "name": "Casacos",
            "description": "Todos os tipos de casaco",
            "image_path": "public/categories/1.jpg",
            "products": [
                {
                    "id": 1,
                    "name": "Casaco de lã",
                    "description": "...",
                    "image_path": "public/products/1.jpg",
                    "stock": 10,
                    "price": 100,
                    "category_id": 1
                },
                {
                    "id": 2,
                    "name": "Casaco de couro",
                    "description": "...",
                    "image_path": "public/products/2.jpg",
                    "stock": 10,
                    "price": 100,
                    "category_id": 1
                }
            ],
        }
    ]
}
```

### Retornar apenas uma categoria
```http
GET /api/categories/{id}
```
#### Não requer autenticação

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | ID da categoria             |

#### Retorna
```json
{
    "id": 1,
    "name": "Casacos",
    "description": "Todos os tipos de casaco",
    "image_path": "public/categories/1.jpg"
}
```

Pode obter os produtos relacionados a uma categoria, basta utilizar o "include" no endpoint.

```http
GET /api/categories/{id}?include=products
```
#### Retorna
```json
{
    "id": 1,
    "name": "Casacos",
    "description": "Todos os tipos de casaco",
    "image_path": "public/categories/1.jpg",
    "products": [
        {
            "id": 1,
            "name": "Casaco de lã",
            "description": "...",
            "image_path": "public/products/1.jpg",
            "stock": 10,
            "price": 100,
            "category_id": 1
        }
    ]
}
```

### Criar uma categoria
```http
POST /api/categories
```
#### Requer autenticação (ADMIN)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `name`         | `string` | **Obrigatório**.
| `description`  | `string` | **Não obrigatório**.


### Atualizar uma categoria
```http
PUT /api/categories/{id}
```
#### Requer autenticação (ADMIN)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `id`           | `int`    | **Obrigatório**.
| `name`         | `string` | **Obrigatório**.
| `description`  | `string` | **Não obrigatório**.

### Deletar uma categoria
```http
DELETE /api/categories/{id}
```
#### Requer autenticação (ADMIN)

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | **Obrigatório**.
---

## Produtos

### Listar todos os produtos
```http
GET /api/products
```
#### Não requer autenticação
#### Retorna
```json
[
    {
        "id": 1,
        "name": "Casaco de lã",
        "description": "Casaco de laranja",
        "image_path": "public/products/1.jpg",
        "stock": 10,
        "price": 100,
        "category_id": 1
    },
    ...
]
```

Pode obter todos os produtos com a categoria, e/ou com os descontos relacionados, basta utilizar o "include" no endpoint.

```http
GET /api/products?include=category,discounts
```
#### Retorna
```json
{
    "data": [
        {
            "id": 1,
            "category_id": 1,
            "name": "Casaco de lã",
            "description": "Casaco de laranja",
            "image_path": "public/products/1.jpg",
            "stock": 10,
            "price": 100,
            "category": {
                "id": 1,
                "name": "Casacos",
                "description": "Todos os tipos de casaco",
                "image_path": "public/categories/1.jpg"
            },
            "discounts": [
                {
                    "id": 1,
                    "description": "Desconto de R$ 10,00",
                    "discount_percentage": 10,
                    "start_date": "2021-01-01",
                    "end_date": "2021-12-31",
                    "product_id": 1
                }
            ]
        },
        ...
    ]
}
```

### Retornar apenas um produto
```http
GET /api/products/{id}
```
#### Não requer autenticação

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | ID do produto               |

#### Retorna
```json
{
    "id": 1,
    "name": "Casaco de lã",
    "description": "Casaco de laranja",
    "image_path": "public/products/1.jpg",
    "stock": 10,
    "price": 100,
    "category_id": 1
}
```

Pode obter todos os produtos com a categoria, e/ou com os descontos relacionados, basta utilizar o "include" no endpoint.


### Criar um produto
```http
POST /api/products
```
#### Requer autenticação (MODERATOR)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `name`         | `string` | **Obrigatório**.|
| `description`  | `string` | **Não obrigatório**.|
|`price`         | `number`    | **Obrigatório**.|
| `stock`        | `int`    | **Obrigatório**.|
| `category_id`  | `int`    | **Obrigatório**.|

### Atualizar um produto
```http
PUT /api/products/{id}
```
#### Requer autenticação (MODERATOR)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `id`           | `int`    | **Obrigatório**.|
| `name`         | `string` | **Não obrigatório**.|
| `description`  | `string` | **Não obrigatório**.|
|`price`         | `number`    | **Não obrigatório**.|
| `category_id`  | `int`    | **Não obrigatório**.|

O estoque não é alterado por essa rota. Para alterar o estoque, utilize a rota de atualização de estoque.

### Atualizar estoque de um produto
```http
POST /api/products/{id}/stock
```
#### Requer autenticação (MODERATOR)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `id`           | `int`    | **Obrigatório**.|
| `stock`        | `int`    | **Obrigatório**.|


### Atualizar imagem de um produto
```http
POST /api/products/image/{id}
```
#### Requer autenticação (MODERATOR)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `id`           | `int`    | **Obrigatório**.|
| `image`        | `file` | **Obrigatório**.|



### Deletar um produto
```http
DELETE /api/products/{id}
```
#### Requer autenticação (ADMIN)

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | **Obrigatório**.
---

## Discounts

### Listar todos os descontos
```http
GET /api/discounts
```
#### Não requer autenticação
#### Retorna
```json
[
    {
        "id": 1,
        "description": "Desconto de R$ 10,00",
        "discount_percentage": 10,
        "start_date": "2021-01-01",
        "end_date": "2021-12-31",
        "product_id": 1
    },
    ...
]
```

Pode obter todos os descontos relacionados a um produto, basta utilizar o "include" no endpoint.

```http 
GET /api/discounts?include=product
```
#### Retorna
```json
{
    "data": [
        {
            "id": 1,
            "description": "Desconto de R$ 10,00",
            "discount_percentage": 10,
            "start_date": "2021-01-01",
            "end_date": "2021-12-31",
            "product": {
                "id": 1,
                "name": "Casaco de lã",
                "description": "Casaco de laranja",
                "image_path": "public/products/1.jpg",
                "stock": 10,
                "price": 100,
                "category_id": 1
            }
        },
        ...
    ]
}

```

### Retornar apenas um desconto
```http
GET /api/discounts/{id}
```
#### Não requer autenticação

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | ID do desconto               |

#### Retorna
```json
{
    "id": 1,
    "description": "Desconto de R$ 10,00",
    "discount_percentage": 10,
    "start_date": "2021-01-01",
    "end_date": "2021-12-31",
    "product_id": 1
}
```

Pode obter o produto relacionado, basta utilizar o "include" no endpoint.

### Criar um desconto
```http
POST /api/discounts
```
#### Requer autenticação (MODERATOR)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `description`  | `string` | **Obrigatório**.|
| `discount_percentage`  | `number`    | **Obrigatório**.|
| `start_date`  | `date`    | **Obrigatório**.|
| `end_date`  | `date`    | **Obrigatório**.|
| `product_id`  | `int`    | **Obrigatório**.|


### Atualizar um desconto
```http
PUT /api/discounts/{id}
```
#### Requer autenticação (MODERATOR)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `id`           | `int`    | **Obrigatório**.|
| `description`  | `string` | **Não obrigatório**.|
| `discount_percentage`  | `number`    | **Não obrigatório**.|
| `start_date`  | `date`    | **Não obrigatório**.|
| `end_date`  | `date`    | **Não obrigatório**.|


### Deletar um desconto
```http
DELETE /api/discounts/{id}
```
#### Requer autenticação (ADMIN)

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | **Obrigatório**.
---

## Coupons

### Listar todos os cupons
```http
GET /api/coupons
```
#### Não requer autenticação
#### Retorna
```json
[
    {
        "id": 1,
        "code": "CODE-YAML",
        "discount_percentage": 10,
        "start_date": "2021-01-01",
        "end_date": "2021-12-31",
    },
    ...
]
```

### Retornar apenas um cupon
```http
GET /api/coupons/{id}
```
#### Não requer autenticação

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | ID do cupon               |

#### Retorna
```json
{
    "id": 1,
    "code": "CODE-YAML",
    "discount_percentage": 10,
    "start_date": "2021-01-01",
    "end_date": "2021-12-31",
}
```

### Criar um cupon
```http
POST /api/coupons
```
#### Requer autenticação (ADMIN)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `code`         | `string` | **Obrigatório**.|
| `discount_percentage`  | `number`    | **Obrigatório**.|
| `start_date`  | `date`    | **Obrigatório**.|
| `end_date`  | `date`    | **Obrigatório**.|

### Atualizar um cupon
```http
PUT /api/coupons/{id}
```
#### Requer autenticação (ADMIN)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `id`           | `int`    | **Obrigatório**.|
| `code`         | `string` | **Não obrigatório**.|
| `discount_percentage`  | `number`    | **Não obrigatório**.|
| `start_date`  | `date`    | **Não obrigatório**.|
| `end_date`  | `date`    | **Não obrigatório**.|


### Deletar um cupon
```http
DELETE /api/coupons/{id}
```
#### Requer autenticação (ADMIN)

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | **Obrigatório**.


### Retornar cupons desativados
```http
GET /api/coupons/disabled
```
#### Não requer autenticação
#### Retorna
```json
[
    {
        "id": 1,
        "code": "CODE-YAML",
        "discount_percentage": 10,
        "start_date": "2021-01-01",
        "end_date": "2021-12-31",
        "deleted_at": "2021-12-31",
    },
    ...
]
```

### Renovar um cupon
```http
POST /api/coupons/{id}/renew
```
#### Requer autenticação (ADMIN)

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | **Obrigatório**.

---

## Cart 

### Ver carrinho do usuário
```http
GET /api/cart
```
#### Requer autenticação (CLIENT)
#### Retorna
```json
{
    "data": {
        "id": 1,
        "user_id": 1,
    }
}
```

### Ver itens do carrinho do usuário
```http
GET /api/cart/items
```
#### Requer autenticação (CLIENT)
#### Retorna
```json
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "items": [
                {
                    "id": 1,
                    "product_id": 1,
                    "quantity": 1,
                    "unit_price": 100,   
                }
            ]
        },
        ...
    ]
}
```

Pode obter os produtos relacionados, basta utilizar o "include" no endpoint. Ver possiveis relações no service ```CartService.php```.

### Atualizar quantidade de um item do carrinho do usuário
```http
PUT /api/cart/items/
```
#### Requer autenticação (CLIENT)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `id`           | `int`    | **Obrigatório**.|
| `quantity`     | `int`    | **Obrigatório**.|
| `product_id`   | `int`    | **Obrigatório**.|

### Deletar um item do carrinho do usuário
```http
DELETE /api/cart/items
```
#### Requer autenticação (CLIENT)

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `product_id`   | `int`    | **Obrigatório**.

### Limpar o carrinho do usuário
```http
DELETE /api/cart/clear
```
#### Requer autenticação (CLIENT)

---

## Orders

### Listar todos os pedidos

```http
GET /api/orders
```

#### Requer autenticação (CLIENT)

#### Retorna
```json
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "address_id": 1,
            "order_date": "2021-12-31",
            "status": "pending",
            "total_amount": 100,
            "order_items": [
                {
                    "id": 1,
                    "order_id": 1,
                    "product_id": 1,
                    "quantity": 1,
                    "unit_price": 100,
                },
                ...
            ]
        },
        {
            "id": 2,
            "user_id": 1,
            "address_id": 1,
            "order_date": "2021-12-31",
            "status": "pending",
            "total_amount": 100,
            "order_items": [
                {
                    "id": 1,
                    "order_id": 1,
                    "product_id": 1,
                    "quantity": 1,
                    "unit_price": 100,
                }
            ]
        }
    ]
}

```

Pode obter os produtos relacionados ao order item, basta utilizar o "include" no endpoint. Ver possiveis relações no service ```OrderService.php```.

### Retornar apenas um pedido

```http 
GET /api/orders/{id}
```

#### Requer autenticação (CLIENT)

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | **Obrigatório**.

#### Retorna
```json
{
    "id": 1,
    "user_id": 1,
    "address_id": 1,
    "order_date": "2021-12-31",
    "status": "pending",
    "total_amount": 100,
    "order_items": [
        {
            "id": 1,
            "order_id": 1,
            "product_id": 1,
            "quantity": 1,
            "unit_price": 100,
        }
    ]
}
```

Pode obter o produto relacionados ao order item, basta utilizar o "include" no endpoint. Ver possiveis relações no service ```OrderService.php```.

### Criar um pedido

```http
POST /api/orders
```

#### Requer autenticação (CLIENT)

Requer ter items no carrinho do usuário.

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
|`address_id`    | `int`    | **Obrigatório**.|
|`coupon_id`     | `int`    | **Obrigatório**.|


### Cancelar um pedido


```http
DELETE /api/orders/{id}
```
Se o pedido passou do status de processing, ele não será cancelado.
#### Requer autenticação (CLIENT)

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | **Obrigatório**.


### Alterar status de um pedido

```http
PUT /api/orders/{id}
```

#### Requer autenticação (MODERATOR)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `id`           | `int`    | **Obrigatório**.|
| `status`       | `string` | **Obrigatório**.|

### Gerar relátorio de vendas semanal
```http
GET /api/relatory/orders
```
#### Requer autenticação (MODERATOR)
#### Retorna
Retorna pdf com relatório de vendas semanal. Inclundo o id das orders, email do cliente, data de criação, status e total do pedido.
