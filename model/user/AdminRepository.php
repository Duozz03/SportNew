<?php

class AdminRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByUsername(string $username): ?Admin
    {
        $sql = "SELECT id, username, password, created_at
                FROM admins
                WHERE username = :username
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        return new Admin(
            (int)$row['id'],
            $row['username'],
            $row['password'],
            $row['created_at']
        );
    }
}