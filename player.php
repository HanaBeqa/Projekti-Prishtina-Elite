<?php
include_once "Database.php";

class Player {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function add($full_name, $number, $position, $image) {
        $stmt = $this->conn->prepare(
            "INSERT INTO players (full_name, number, position, image)
             VALUES (?,?,?,?)"
        );
        return $stmt->execute([$full_name, $number, $position, $image]);
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM players ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $full_name, $number, $position, $image) {
        $stmt = $this->conn->prepare(
            "UPDATE players SET full_name=?, number=?, position=?, image=? WHERE id=?"
        );
        return $stmt->execute([$full_name, $number, $position, $image, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM players WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
