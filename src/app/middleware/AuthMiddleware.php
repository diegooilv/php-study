<?php

class AuthMiddleware
{
    public static function handle()
    {
        try {
            $headers = getallheaders();
            $header = $headers['Authorization'] ?? $headers['authorization'] ?? null;
            if (!$header) {
                Response::json(['erro' => 'Acesso não autorizadoa'], 401);
            }
            $token = str_replace('Bearer ', '', $header);

            $tokenModel = new TokenModel();
            $row = $tokenModel->findByToken($token);

            if (!$row) {
                Response::json(['erro' => 'Acesso não autorizado'], 401);
            }

            if (strtotime($row['expires_at']) < time()) {
                $tokenModel->deleteByToken($token);
                Response::json(['erro' => 'Token expirado'], 401);
            }

            return $row;

        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::json(['erro' => 'Erro interno'], 500);
        }
    }

    public static function admin()
    {
        $row = self::handle();
        $userModel = new UserModel();
        $user = $userModel->findById($row['user_id']);
        if ($user['role'] !== 'admin') {
            Response::json(['erro' => 'Acesso não autorizado'], 403);
        }

        return $row;
    }
}
