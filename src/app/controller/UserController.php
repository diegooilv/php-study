<?php

// name, email, password, phone, bio
class UserController
{
    public function register()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            ValidationMiddleware::required(
                $body,
                ['name', 'email', 'password']
            );

            $userModel = new UserModel();
            $exists = $userModel->findByEmail($body['email']);

            if ($exists) {
                Response::json(['erro' => 'Email já cadastrado'], 409);
            }

            $user = $userModel->create($body);
            Response::json(['user' => $user], 201);
        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::json(['erro' => 'Erro interno'], 500);
        }
    }

    public function index()
    {
        try {
            $row = AuthMiddleware::admin();
            if (!$row) {
                Response::json(['erro' => 'Acesso Negado!'], 403);
            }

            $userModel = new UserModel();
            $users = $userModel->index();
            Response::json($users, 200);
        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::json(['erro' => 'Erro interno'], 500);
        }
    }

    public function show($id)
    {
        try {
            $userModel = new UserModel();
            $user = $userModel->findById($id);
            if (!$user) {
                Response::json(['erro' => 'ID Inválido!'], 404);
            }
            Response::json($user, 200);

        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::json(['erro' => 'Erro interno'], 500);
        }
    }
    public function patch($id)
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $row = AuthMiddleware::handle();
            if ($row['user_id'] != $id) {
                Response::json(['erro' => 'Você não é esse usuário!'], 403);
            }

            $userModel = new UserModel();
            $status = $userModel->update($id, $body);
            if ($status) {
                Response::json(['status' => 'Usuário Atualizado!'], 200);
            } else {
                Response::json(['erro' => 'ID Inválido!'], 404);
            }

        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::json(['erro' => 'Erro interno'], 500);
        }
    }

    public function update($id)
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $row = AuthMiddleware::handle();
            if ($row['user_id'] != $id) {
                Response::json(['erro' => 'Você não é esse usuário!'], 403);
            }

            ValidationMiddleware::required(
                $body,
                ['name', 'phone', 'bio']
            );

            $userModel = new UserModel();
            $status = $userModel->update($id, $body);
            if ($status) {
                Response::json(['status' => 'Usuário Atualizado!'], 200);
            } else {
                Response::json(['erro' => 'ID Inválido!'], 404);
            }

        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::json(['erro' => 'Erro interno'], 500);
        }
    }

    public function login()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            ValidationMiddleware::required($body, ['email', 'password']);
            $userModel = new UserModel();
            $user = $userModel->findByEmail($body['email']);
            if (!$user) {
                Response::json(['erro' => 'Email Inválido!'], 404);
            }

            if (!password_verify($body['password'], $user['password'])) {
                Response::json(['erro' => 'Acesso Não Autorizado!'], 401);
            }

            $tokenModel = new TokenModel();
            $token = $tokenModel->create($user['id']);
            Response::json(['token' => $token], 200);

        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::json(['erro' => 'Erro interno'], 500);
        }
    }
}