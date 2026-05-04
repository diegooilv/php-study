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
            $body = json_decode(file_get_contents('php://input'), true);
            ValidationMiddleware::required($body, ['admin']);
            // temporary
            if ($body['admin'] !== 'diegooilv') {
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
}