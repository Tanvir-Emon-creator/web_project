<?php
require_once __DIR__ . '/../config/database.php';

class Property
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function create($title, $description, $price, $type, $image)
    {
        $sql = "INSERT INTO properties (title, description, price, type, image)
                VALUES (:title, :description, :price, :type, :image)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':title'       => $title,
            ':description' => $description,
            ':price'       => $price,
            ':type'        => $type,
            ':image'       => $image
        ]);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM properties ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM properties WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description, $price, $type, $image = null)
    {
        $sql = "UPDATE properties SET title=:title, description=:description, price=:price, type=:type";
        if ($image) {
            $sql .= ", image=:image";
        }
        $sql .= " WHERE id=:id";

        $stmt = $this->conn->prepare($sql);

        $params = [
            ':id'          => $id,
            ':title'       => $title,
            ':description' => $description,
            ':price'       => $price,
            ':type'        => $type
        ];

        if ($image) {
            $params[':image'] = $image;
        }

        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM properties WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
