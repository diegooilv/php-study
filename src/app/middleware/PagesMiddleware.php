<?php

class PagesMiddleware
{
    public static function auth()
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $token = $_SESSION['userToken'] ?? null;
            if (!$token) {
                header('Location: /login');
                exit;
            }
            $tokenModel = new TokenModel();
            $row = $tokenModel->findByToken($token);

            if (!$row) {
                header('Location: /login');
                exit;
            }

            if (strtotime($row['expires_at']) < time()) {
                $tokenModel->deleteByToken($token);
                header('Location: /login');
                exit;
            }
            return $row;

        } catch (Exception $e) {
            error_log($e->getMessage());
            header('Location: /login');
            exit;
        }
    }

    public static function admin()
    {
        $row = self::auth();
        $userModel = new UserModel();
        $user = $userModel->findById($row['user_id']);
        if ($user['role'] !== 'admin') {
            // temporary
            header('Location: /login');
            exit;
        }
        return $row;
    }
}
