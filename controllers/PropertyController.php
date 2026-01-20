<?php
session_start();
require_once __DIR__ . '/../models/Property.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/auth/login.php");
    exit;
}

$propertyModel = new Property();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $propertyModel->delete($id);
    header("Location: ../views/admin/properties.php");
    exit;
}
