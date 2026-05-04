<?php

class UserModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (name, email, password, phone, bio) VALUES (?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['phone'] ?? null,
            $data['bio'] ?? null,
        ]);

        return $this->pdo->lastInsertId();
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare(
            'UPDATE users SET name = ?, phone = ?, bio = ? WHERE id = ?'
        );

        $stmt->execute([
            $data['name'],
            $data['phone'] ?? null,
            $data['bio'] ?? null,
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function index()
    {
        $stmt = $this->pdo->query('SELECT * FROM users');
        return $stmt->fetchAll();
    }
}