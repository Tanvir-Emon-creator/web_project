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

    // Find user by email
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Find user by ID
    public function findById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create user (signup)
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

    // Update name and role
    public function updateProfile($user_id, $name, $role)
    {
        $sql = "UPDATE users SET name = :name, role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':role' => $role,
            ':id'   => $user_id
        ]);
    }

    // Update password
    public function updatePassword($user_id, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':password' => $hashedPassword,
            ':id'       => $user_id
        ]);
    }

    // Get all users except admin
    public function getAllExceptAdmin()
    {
        $sql = "SELECT * FROM users WHERE role != 'admin'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
