<?php
include_once "Database.php";

class Poster {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
        $this->conn->exec("set names utf8");
    }

    
    public function add($image_path) {
        $stmt = $this->conn->prepare("INSERT INTO posters (image_path, created_at) VALUES (?, NOW())");
        return $stmt->execute([$image_path]);
    }

    
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM posters ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function update($id, $image_path) {
        $stmt = $this->conn->prepare("UPDATE posters SET image_path=? WHERE id=?");
        return $stmt->execute([$image_path, $id]);
    }

    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM posters WHERE id=?");
        return $stmt->execute([$id]);
    }

   
    public function get($id) {
        $stmt = $this->conn->prepare("SELECT * FROM posters WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
