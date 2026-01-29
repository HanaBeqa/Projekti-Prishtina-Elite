<?php
include "Database.php";

class Contact {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    
    public function add($user_name, $email, $message) {
        $stmt = $this->conn->prepare("INSERT INTO contact_messages (user_name, email, message) VALUES (?, ?, ?)");
        return $stmt->execute([$user_name, $email, $message]);
    }

   
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

  
    public function update($id, $user_name, $email, $message) {
        $stmt = $this->conn->prepare("UPDATE contact_messages SET user_name=?, email=?, message=? WHERE id=?");
        return $stmt->execute([$user_name, $email, $message, $id]);
    }

    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM contact_messages WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
