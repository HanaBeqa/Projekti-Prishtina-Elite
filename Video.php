<?php
include_once "Database.php";

class Video {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
        $this->conn->exec("set names utf8");
    }

    public function add($title, $description, $iframe_url) {
        $stmt = $this->conn->prepare("INSERT INTO videos (title, description, iframe_url, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$title, $description, $iframe_url]);
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM videos ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->conn->prepare("SELECT * FROM videos WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description, $iframe_url) {
        $stmt = $this->conn->prepare("UPDATE videos SET title=?, description=?, iframe_url=? WHERE id=?");
        return $stmt->execute([$title, $description, $iframe_url, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM videos WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
