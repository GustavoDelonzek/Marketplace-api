## Documentação da API

Segue abaixo o esquema do banco de dados:

![Exemplo](public/doc-images/database-schema.png)


---
### Autenticação
---

#### Registrar usuário
```http
POST /api/register
```
##### Não requer autenticação

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `name`         | `string` | **Obrigatório**. Nome do usuário   |
| `email`        | `string` | **Obrigatório**. Email válido       |
| `password`     | `string` | **Obrigatório**. Senha segura       |
| `password_confirmation` | `string` | **Obrigatório**. Confirmação da senha |

#### Login
```http
POST /api/login
```
##### Não requer autenticação


| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `email`        | `string` | **Obrigatório**. Email cadastrado   |
| `password`     | `string` | **Obrigatório**. Senha              |


#### Verificação de email
```http
GET /api/email/verify/{id}/{hash}
```
##### Requer autenticação(token)


| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | ID do usuário               |
| `hash`    | `string` | Hash de verificação         |

#### Reenviar email de verificação
```http
POST /api/email/verification-notification
```
##### Requer autenticação(token)


#### Enviar email de recuperação de senha
```http
POST /api/password/forgot-password
```
##### Requer autenticação(token)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `email`        | `string` | **Obrigatório**.


#### Validar token de recuperação de senha
```http
POST /api/password/reset-password
```
##### Requer autenticação(token)

| Parâmetro     | Tipo     | Descrição                     |
| :------------- | :------- | :------------------------------ |
| `token`        | `string` | **Obrigatório**.|
| `email`        | `string` | **Obrigatório**.|
| `password`     | `string` | **Obrigatório**.|
| `password_confirmation` | `string` | **Obrigatório**.|

---

### Categorias
---

#### Listar todas categorias
```http
GET /api/categories
```
##### Não requer autenticação
##### Retorna
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
##### Retorna
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

#### Retornar apenas uma categoria
```http
GET /api/categories/{id}
```
##### Não requer autenticação

| Parâmetro | Tipo     | Descrição                    |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | ID da categoria             |

##### Retorna
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
##### Retorna
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

---
