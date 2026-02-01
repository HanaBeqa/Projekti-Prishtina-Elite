<?php
include_once "Database.php";

class Video {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
        $this->conn->exec("set names utf8");
    }

    
    public function add($iframe, $description, $date) {
        $stmt = $this->conn->prepare("INSERT INTO videos (iframe, description, date_created) VALUES (?, ?, ?)");
        return $stmt->execute([$iframe, $description, $date]);
    }

  
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM videos ORDER BY date_created DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function get($id) {
        $stmt = $this->conn->prepare("SELECT * FROM videos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function update($id, $iframe, $description, $date) {
        $stmt = $this->conn->prepare("UPDATE videos SET iframe=?, description=?, date_created=? WHERE id=?");
        return $stmt->execute([$iframe, $description, $date, $id]);
    }

   
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM videos WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>
