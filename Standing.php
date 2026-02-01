<?php
include "Database.php";

class Standing {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function add($name, $points, $played, $won, $lost){
        $stmt = $this->conn->prepare(
            "INSERT INTO standings (name, points, played, won, lost) VALUES (?,?,?,?,?)"
        );
        return $stmt->execute([$name, $points, $played, $won, $lost]);
    }

    public function getAll(){
        $stmt = $this->conn->query(
            "SELECT * FROM standings ORDER BY points DESC, won DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $points, $played, $won, $lost){
        $stmt = $this->conn->prepare(
            "UPDATE standings SET name=?, points=?, played=?, won=?, lost=? WHERE id=?"
        );
        return $stmt->execute([$name, $points, $played, $won, $lost, $id]);
    }

    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM standings WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>

