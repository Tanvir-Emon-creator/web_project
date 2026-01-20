<?php
require_once __DIR__ . '/../config/database.php';

class User
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $email, $password, $role)
    {
        $sql = "INSERT INTO users (name, email, password, role)
                VALUES (:name, :email, :password, :role)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':name'     => $name,
            ':email'    => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':role'     => $role
        ]);
    }
}
