<?php

class TokenModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function create($id)
    {
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $this->pdo->prepare(
            'INSERT INTO tokens (user_id, token, expires_at) VALUES (?, ?, ?)'
        );

        $stmt->execute([$id, $token, $expires_at]);
        return $token;
    }

    public function findByToken($token)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tokens WHERE token = ?');
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function deleteByToken($token)
    {
        $stmt = $this->pdo->prepare('DELETE FROM tokens WHERE token = ?');
        $stmt->execute([$token]);
    }

    public function deleteByUserId($userId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM tokens WHERE user_id = ?');
        $stmt->execute([$userId]);
    }
}