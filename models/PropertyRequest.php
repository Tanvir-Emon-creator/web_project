<?php
require_once __DIR__ . '/../config/database.php';

class PropertyRequest
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function getAll()
    {
        $sql = "SELECT pr.id, u.name AS user_name, u.email AS user_email, 
                       p.title AS property_title, p.type AS property_type, 
                       pr.status, pr.created_at
                FROM property_requests pr
                JOIN users u ON pr.user_id = u.id
                JOIN properties p ON pr.property_id = p.id
                ORDER BY pr.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE property_requests SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':status'=>$status, ':id'=>$id]);
    }
}
