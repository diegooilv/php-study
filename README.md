# API - PHP

Projeto de estudo de uma API REST em PHP puro, sem frameworks.

## Estrutura

```txt
├── docker/
│   ├── apache.conf
│   └── init.sql
├── src/
│   ├── app/
│   │   ├── api/
│   │   │   └── index.php
│   │   ├── controller/
│   │   │   ├── PagesController.php
│   │   │   └── UserController.php
│   │   ├── core/
│   │   │   ├── Database.php
│   │   │   ├── Require.php
│   │   │   ├── Response.php
│   │   │   └── Router.php
│   │   ├── middleware/
│   │   │   ├── AuthMiddleware.php
│   │   │   ├── PagesMiddleware.php
│   │   │   └── ValidationMiddleware.php
│   │   ├── model/
│   │   │   ├── TokenModel.php
│   │   │   └── UserModel.php
│   │   └── pages/
│   │       ├── 404.php
│   │       ├── dashboard.php
│   │       ├── error.php
│   │       ├── index.php
│   │       ├── logout.php
│   │       ├── register.php
│   │       └── require.php
│   ├── config/
│   │   └── database.php
│   └── public/
│       └── index.php
├── docker-compose.yml
├── Dockerfile
├── .env
├── .gitattributes
├── .gitignore
├── LICENSE
└── README.md
```

## Rotas da API

Base: `http://localhost:8080/api`

| Método | Rota                | Descrição                 | Auth                     |
| ------ | ------------------- | ------------------------- | ------------------------ |
| POST   | `/user/register`    | Cadastrar usuário         | -                        |
| POST   | `/user/login`       | Login — retorna token     | -                        |
| POST   | `/user/logout`      | Logout — invalida token   | `Bearer` (dono)          |
| GET    | `/user/index`       | Listar todos os usuários  | `Bearer` (admin)         |
| GET    | `/user/{id}`        | Buscar usuário por ID     | `Bearer` (dono ou admin) |
| PATCH  | `/user/update/{id}` | Atualização parcial       | `Bearer` (dono)          |
| PUT    | `/user/update/{id}` | Atualização completa      | `Bearer` (dono)          |
| DELETE | `/user/delete`      | Excluir conta autenticada | `Bearer` (dono)          |

## Páginas

Base: `http://localhost:8080`

| Página       | Descrição                         |
| ------------ | --------------------------------- |
| `/`          | Página inicial                    |
| `/register`  | Cadastro de usuários              |
| `/dashboard` | Painel autenticado                |
| `/logout`    | Encerrar sessão                   |
| `/require`   | Página de requisitos/autenticação |
| `/error`     | Página de erro personalizada      |
| `*`          | Página 404                        |

## Autenticação

As rotas protegidas exigem o token no header:

```txt
Authorization: Bearer seu_token_aqui
```

## Credenciais de teste

### Admin

```json
{
  "email": "diego@email.com",
  "password": "password"
}
```

### Usuário

```json
{
  "email": "edu@email.com",
  "password": "password"
}
```

Atualizado em: 09/05/2026
