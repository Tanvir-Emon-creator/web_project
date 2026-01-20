<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['buyer','renter'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: browse_properties.php");
    exit;
}

$property_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Check property type
$stmt = $conn->prepare("SELECT * FROM properties WHERE id=:id LIMIT 1");
$stmt->execute([':id'=>$property_id]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$property) {
    die("Property not found");
}

// Insert request
$stmt = $conn->prepare("INSERT INTO property_requests (user_id, property_id, request_type) VALUES (:uid, :pid, :type)");
$stmt->execute([
    ':uid' => $user_id,
    ':pid' => $property_id,
    ':type'=> $property['type']
]);

echo "Request sent successfully! <a href='browse_properties.php'>Back</a>";
