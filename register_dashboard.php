<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include "Register.php";
$register = new Register();


if(isset($_GET['delete'])){
    $register->delete($_GET['delete']);
    header("Location: register_dashboard.php");
    exit;
}


if(isset($_POST['save'])){
    $id = $_POST['id'] ?? null;
    $emri = $_POST['emri'];
    $mbiemri = $_POST['mbiemri'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if($id){ 
        $register->update($id, $emri, $mbiemri, $email, $phone);
    } else { 
        $register->add($emri, $mbiemri, $email, $phone);
    }
    header("Location: register_dashboard.php");
    exit;
}

$allRegisters = $register->getAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registers Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>
<h2>Registers Dashboard</h2>
<a href="dashboard.php">Back to main dashboard</a>
<table>
<tr><th>ID</th><th>Emri</th><th>Mbiemri</th><th>Email</th><th>Phone</th><th>Actions</th></tr>
<?php foreach($allRegisters as $r): ?>
<tr>
    <td><?= $r['id'] ?></td>
    <td><?= $r['emri'] ?></td>
    <td><?= $r['mbiemri'] ?></td>
    <td><?= $r['email'] ?></td>
    <td><?= $r['phone'] ?></td>
    <td>
        <a href="register_dashboard.php?edit=<?= $r['id'] ?>">Edit</a> |
        <a href="register_dashboard.php?delete=<?= $r['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit Register</h3>
<?php 
$editData = ['id'=>'','emri'=>'','mbiemri'=>'','email'=>'','phone'=>''];
if(isset($_GET['edit'])){
    foreach($allRegisters as $r){
        if($r['id'] == $_GET['edit']){
            $editData = $r;
            break;
        }
    }
}
?>
<form method="post">
    <input type="hidden" name="id" value="<?= $editData['id'] ?>">
    <input type="text" name="emri" placeholder="Emri" value="<?= $editData['emri'] ?>" required>
    <input type="text" name="mbiemri" placeholder="Mbiemri" value="<?= $editData['mbiemri'] ?>" required>
    <input type="email" name="email" placeholder="Email" value="<?= $editData['email'] ?>" required>
    <input type="text" name="phone" placeholder="Phone" value="<?= $editData['phone'] ?>">
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>
