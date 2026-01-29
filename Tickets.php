<?php
include "Database.php";

class Tickets {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    
    public function add($user_name, $event_name, $quantity, $email) {
        $stmt = $this->conn->prepare("INSERT INTO tickets_orders (user_name, event_name, quantity, email) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_name, $event_name, $quantity, $email]);
    }

    
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM tickets_orders ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function update($id, $user_name, $event_name, $quantity, $email) {
        $stmt = $this->conn->prepare("UPDATE tickets_orders SET user_name=?, event_name=?, quantity=?, email=? WHERE id=?");
        return $stmt->execute([$user_name, $event_name, $quantity, $email, $id]);
    }

    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM tickets_orders WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
