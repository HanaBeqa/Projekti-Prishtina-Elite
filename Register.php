<?php
include "Database.php";

class Register {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    
    public function add($emri, $mbiemri, $email, $phone) {
        $stmt = $this->conn->prepare("INSERT INTO registers (emri, mbiemri, email, phone) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$emri, $mbiemri, $email, $phone]);
    }

    
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM registers ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function update($id, $emri, $mbiemri, $email, $phone) {
        $stmt = $this->conn->prepare("UPDATE registers SET emri=?, mbiemri=?, email=?, phone=? WHERE id=?");
        return $stmt->execute([$emri, $mbiemri, $email, $phone, $id]);
    }

    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM registers WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
