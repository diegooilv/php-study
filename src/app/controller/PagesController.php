<?php
class PagesController
{

    public static function verifyLogin()
    {
        $row = PagesMiddleware::auth();
        $userModel = new UserModel();
        return $userModel->findById($row['user_id']);
    }

    public static function verifyAdm()
    {
        $row = PagesMiddleware::admin();
        $userModel = new UserModel();
        return $userModel->findById($row['user_id']);
    }

    public static function login()
    {
        try {
            $body = $_POST;
            $userModel = new UserModel();
            $user = $userModel->findByEmail($body['email']);
            if (!$user) {
                header('Location: /login');
                exit();
            }

            if (!password_verify($body['password'], $user['password'])) {
                header('Location: /login');
                exit();
            }

            $tokenModel = new TokenModel();
            $token = $tokenModel->create($user['id']);
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['userToken'] = $token;
            header('Location: /dashboard');
            exit;

        } catch (Exception $e) {
            error_log($e->getMessage());
            header('Location: /login');
            exit();
        }
    }

    public static function logout()
    {
        try {
            $row = PagesMiddleware::auth();
            $tokenModel = new TokenModel();
            $tokenModel->deleteByToken($row['token']);
            if (session_status() !== PHP_SESSION_NONE) {
                $_SESSION = [];
                session_destroy();
            }
            header('Location: /login');
            exit();

        } catch (Exception $e) {
            error_log($e->getMessage());
            header('Location: /login');
            exit();
        }
    }

    public static function register()
    {
        try {
            $body = $_POST;
            $userModel = new UserModel();
            $exists = $userModel->findByEmail($body['email']);

            if ($exists) {
                header('Location: /error?code=409&msg=Email já em uso.');
                exit;
            }

            $user = $userModel->create($body);
            $tokenModel = new TokenModel();
            $token = $tokenModel->create($user);
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['userToken'] = $token;
            header('Location: /dashboard');
            exit;

        } catch (Exception $e) {
            error_log($e->getMessage());
            Response::internalError();
        }
    }
}