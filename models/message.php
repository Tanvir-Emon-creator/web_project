<?php

require_once __DIR__ . '/../config/database.php';

class Message
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Send a message
    public function send($sender_id, $receiver_id, $message)
    {
        $sql = "INSERT INTO messages (sender_id, receiver_id, message) 
                VALUES (:sender, :receiver, :message)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':sender' => $sender_id,
            ':receiver' => $receiver_id,
            ':message' => $message
        ]);
    }

    // Get all messages between two users
    public function getConversation($user1, $user2)
    {
        $sql = "SELECT m.*, u1.name AS sender_name, u2.name AS receiver_name
                FROM messages m
                JOIN users u1 ON m.sender_id = u1.id
                JOIN users u2 ON m.receiver_id = u2.id
                WHERE (sender_id = :user1 AND receiver_id = :user2) 
                   OR (sender_id = :user2 AND receiver_id = :user1)
                ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':user1' => $user1,
            ':user2' => $user2
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all conversations for a user (latest message only)
    public function getInbox($user_id)
    {
        $sql = "SELECT m.*, u.name AS sender_name
                FROM messages m
                JOIN users u ON m.sender_id = u.id
                WHERE m.receiver_id = :uid
                ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
