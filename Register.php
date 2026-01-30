<?php
include "Database.php";

class Register {
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function add($full_name, $parent_name, $age, $gender, $school, $email, $phone){
        $stmt = $this->conn->prepare("INSERT INTO registers (full_name,parent_name,age,gender,school,email,phone) VALUES (?,?,?,?,?,?,?)");
        return $stmt->execute([$full_name,$parent_name,$age,$gender,$school,$email,$phone]);
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM registers ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id,$full_name,$parent_name,$age,$gender,$school,$email,$phone){
        $stmt = $this->conn->prepare("UPDATE registers SET full_name=?, parent_name=?, age=?, gender=?, school=?, email=?, phone=? WHERE id=?");
        return $stmt->execute([$full_name,$parent_name,$age,$gender,$school,$email,$phone,$id]);
    }

    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM registers WHERE id=?");
        return $stmt->execute([$id]);
    }
}

?>
