<?php
include_once "Database.php";

class Match {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
        $this->conn->exec("set names utf8");
    }

    public function add($team_opponent, $image_path, $match_date = null) {
        $stmt = $this->conn->prepare("INSERT INTO matches (team_opponent, image_path, match_date) VALUES (?, ?, ?)");
        return $stmt->execute([$team_opponent, $image_path, $match_date]);
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM matches ORDER BY match_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->conn->prepare("SELECT * FROM matches WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $team_opponent, $image_path, $match_date = null) {
        $stmt = $this->conn->prepare("UPDATE matches SET team_opponent=?, image_path=?, match_date=? WHERE id=?");
        return $stmt->execute([$team_opponent, $image_path, $match_date, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM matches WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
