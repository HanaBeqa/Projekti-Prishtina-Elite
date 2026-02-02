<?php
include_once "Database.php";

class Users {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
        $this->conn->exec("set names utf8");
    }


    public function getAll() {
        $stmt = $this->conn->query("SELECT id, username, role, created_at FROM users ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->conn->prepare("SELECT id, username, role FROM users WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
