<?php
include "Database.php";

class Merch {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // CREATE
    public function add($user_name, $product_name, $quantity, $email) {
        $stmt = $this->conn->prepare("INSERT INTO merch_orders (user_name, product_name, quantity, email) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_name, $product_name, $quantity, $email]);
    }

    // READ
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM merch_orders ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update($id, $user_name, $product_name, $quantity, $email) {
        $stmt = $this->conn->prepare("UPDATE merch_orders SET user_name=?, product_name=?, quantity=?, email=? WHERE id=?");
        return $stmt->execute([$user_name, $product_name, $quantity, $email, $id]);
    }

    // DELETE
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM merch_orders WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
