<?php
include "Database.php";

class Merch {
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function add($full_name, $email, $phone, $jersey_type, $size) {
        $stmt = $this->conn->prepare("INSERT INTO merch_orders (full_name,email,phone,jersey_type,size) VALUES (?,?,?,?,?)");
        return $stmt->execute([$full_name,$email,$phone,$jersey_type,$size]);
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM merch_orders ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id,$full_name,$email,$phone,$jersey_type,$size){
        $stmt = $this->conn->prepare("UPDATE merch_orders SET full_name=?, email=?, phone=?, jersey_type=?, size=? WHERE id=?");
        return $stmt->execute([$full_name,$email,$phone,$jersey_type,$size,$id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM merch_orders WHERE id=?");
        return $stmt->execute([$id]);
    }
}

?>
