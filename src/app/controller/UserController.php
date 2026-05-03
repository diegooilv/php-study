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
            Response::json(['erro' => $e->getMessage()], 500);
        }
    }
}