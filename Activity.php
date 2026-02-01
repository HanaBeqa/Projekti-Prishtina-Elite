<?php
include_once "Database.php";

class Activity {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function add($title, $description, $images) {
        $stmt = $this->conn->prepare(
            "INSERT INTO activities (title, description, images) VALUES (?,?,?)"
        );
        return $stmt->execute([$title, $description, $images]);
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM activities ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->conn->prepare("SELECT * FROM activities WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description, $images) {
        $stmt = $this->conn->prepare(
            "UPDATE activities SET title=?, description=?, images=? WHERE id=?"
        );
        return $stmt->execute([$title, $description, $images, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM activities WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
