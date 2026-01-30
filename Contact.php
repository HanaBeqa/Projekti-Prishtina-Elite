<?php
include "Database.php";

class Contact {
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function add($full_name, $email, $phone, $subject, $message) {
        $stmt = $this->conn->prepare("INSERT INTO contact_messages (full_name,email,phone,subject,message) VALUES (?,?,?,?,?)");
        return $stmt->execute([$full_name, $email, $phone, $subject, $message]);
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $full_name, $email, $phone, $subject, $message) {
        $stmt = $this->conn->prepare("UPDATE contact_messages SET full_name=?, email=?, phone=?, subject=?, message=? WHERE id=?");
        return $stmt->execute([$full_name, $email, $phone, $subject, $message, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM contact_messages WHERE id=?");
        return $stmt->execute([$id]);
    }
}

?>
