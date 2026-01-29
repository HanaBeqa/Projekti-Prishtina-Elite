<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include "Merch.php";
$merch = new Merch();

if(isset($_GET['delete'])){
    $merch->delete($_GET['delete']);
    header("Location: merch_dashboard.php");
    exit;
}

if(isset($_POST['save'])){
    $id = $_POST['id'] ?? null;
    $user_name = $_POST['user_name'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $email = $_POST['email'];

    if($id){
        $merch->update($id,$user_name,$product_name,$quantity,$email);
    } else {
        $merch->add($user_name,$product_name,$quantity,$email);
    }
    header("Location: merch_dashboard.php");
    exit;
}

$allMerch = $merch->getAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Merch Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>
<h2>Merch Orders Dashboard</h2>
<a href="dashboard.php">Back to main dashboard</a>
<table>
<tr><th>ID</th><th>User Name</th><th>Product</th><th>Quantity</th><th>Email</th><th>Actions</th></tr>
<?php foreach($allMerch as $m): ?>
<tr>
    <td><?= $m['id'] ?></td>
    <td><?= $m['user_name'] ?></td>
    <td><?= $m['product_name'] ?></td>
    <td><?= $m['quantity'] ?></td>
    <td><?= $m['email'] ?></td>
    <td>
        <a href="merch_dashboard.php?edit=<?= $m['id'] ?>">Edit</a> |
        <a href="merch_dashboard.php?delete=<?= $m['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit Merch Order</h3>
<?php 
$editData = ['id'=>'','user_name'=>'','product_name'=>'','quantity'=>'','email'=>''];
if(isset($_GET['edit'])){
    foreach($allMerch as $m){
        if($m['id']==$_GET['edit']){
            $editData=$m; break;
        }
    }
}
?>
<form method="post">
    <input type="hidden" name="id" value="<?= $editData['id'] ?>">
    <input type="text" name="user_name" placeholder="User Name" value="<?= $editData['user_name'] ?>" required>
    <input type="text" name="product_name" placeholder="Product Name" value="<?= $editData['product_name'] ?>" required>
    <input type="number" name="quantity" placeholder="Quantity" value="<?= $editData['quantity'] ?>" required>
    <input type="email" name="email" placeholder="Email" value="<?= $editData['email'] ?>" required>
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>
