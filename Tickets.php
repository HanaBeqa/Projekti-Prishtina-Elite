<?php
include "Database.php";

class Tickets {
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function add($full_name, $team, $quantity, $seat_type){
        $stmt = $this->conn->prepare("INSERT INTO tickets_orders (full_name,team,quantity,seat_type) VALUES (?,?,?,?)");
        return $stmt->execute([$full_name,$team,$quantity,$seat_type]);
    }

    public function getAll(){
        $stmt = $this->conn->query("SELECT * FROM tickets_orders ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id,$full_name,$team,$quantity,$seat_type){
        $stmt = $this->conn->prepare("UPDATE tickets_orders SET full_name=?, team=?, quantity=?, seat_type=? WHERE id=?");
        return $stmt->execute([$full_name,$team,$quantity,$seat_type,$id]);
    }

    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM tickets_orders WHERE id=?");
        return $stmt->execute([$id]);
    }
}

?>
