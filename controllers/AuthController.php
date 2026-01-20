<?php
session_start();
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function login($email, $password)
    {
        $user = $this->user->findByEmail($email);

        if (!$user) {
            return "User not found";
        }

        if (!password_verify($password, $user['password'])) {
            return "Invalid password";
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['role']    = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: ../views/admin/dashboard.php");
        } elseif ($user['role'] === 'buyer') {
            header("Location: ../views/buyer/dashboard.php");
        } else {
            header("Location: ../views/renter/dashboard.php");
        }
        exit;
    }

    public function logout()
    {
        session_destroy();
        header("Location: ../views/auth/login.php");
        exit;
    }
}
