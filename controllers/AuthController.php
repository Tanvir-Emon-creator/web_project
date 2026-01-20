<?php
session_start();
require_once __DIR__ . '/../models/User.php';

// LOGOUT HANDLING
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $auth = new AuthController();
    $auth->logout();
}

// REGISTRATION HANDLING
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $auth = new AuthController();
    $auth->register($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role']);
}

// LOGIN HANDLING
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $auth = new AuthController();
    $auth->login($_POST['email'], $_POST['password']);
}

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
            $_SESSION['error'] = "User not found";
            header("Location: ../views/auth/login.php");
            exit;
        }

        if (!password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Invalid password";
            header("Location: ../views/auth/login.php");
            exit;
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

    public function register($name, $email, $password, $role)
{
    // Only allow buyer or renter
    if (!in_array($role, ['buyer', 'renter'])) {
        $_SESSION['error'] = "Invalid role selected.";
        header("Location: ../views/auth/register.php");
        exit;
    }

    $user = new User();
    $existingUser = $user->findByEmail($email);

    if ($existingUser) {
        $_SESSION['error'] = "Email already exists.";
        header("Location: ../views/auth/register.php");
        exit;
    }

    $user->create($name, $email, $password, $role);

    $_SESSION['success'] = "Registration successful! You can now login.";
    header("Location: ../views/auth/login.php");
    exit;
}


    public function logout()
    {
        session_destroy();
        header("Location: ../views/auth/login.php");
        exit;
    }
}
