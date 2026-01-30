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
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $jersey_type = $_POST['jersey_type'];
    $size = $_POST['size'];

    if($id){
        $merch->update($id, $full_name, $email, $phone, $jersey_type, $size);
    } else {
        $merch->add($full_name, $email, $phone, $jersey_type, $size);
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
<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Jersey Type</th>
    <th>Size</th>
    <th>Actions</th>
</tr>
<?php foreach($allMerch as $m): ?>
<tr>
    <td><?= $m['id'] ?></td>
    <td><?= $m['full_name'] ?></td>
    <td><?= $m['email'] ?></td>
    <td><?= $m['phone'] ?></td>
    <td><?= $m['jersey_type'] ?></td>
    <td><?= $m['size'] ?></td>
    <td>
        <a href="merch_dashboard.php?edit=<?= $m['id'] ?>">Edit</a> |
        <a href="merch_dashboard.php?delete=<?= $m['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit Merch Order</h3>
<?php
$editData = ['id'=>'','full_name'=>'','email'=>'','phone'=>'','jersey_type'=>'','size'=>''];
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
    <input type="text" name="full_name" placeholder="Full Name" value="<?= $editData['full_name'] ?>" required>
    <input type="email" name="email" placeholder="Email" value="<?= $editData['email'] ?>" required>
    <input type="text" name="phone" placeholder="Phone" value="<?= $editData['phone'] ?>" required>
    <select name="jersey_type" required>
        <option value="">Select Jersey</option>
        <option value="Home" <?= $editData['jersey_type']=='Home'?'selected':'' ?>>Home</option>
        <option value="Away" <?= $editData['jersey_type']=='Away'?'selected':'' ?>>Away</option>
    </select>
    <select name="size" required>
        <option value="">Select Size</option>
        <option value="S" <?= $editData['size']=='S'?'selected':'' ?>>S</option>
        <option value="M" <?= $editData['size']=='M'?'selected':'' ?>>M</option>
        <option value="L" <?= $editData['size']=='L'?'selected':'' ?>>L</option>
        <option value="XL" <?= $editData['size']=='XL'?'selected':'' ?>>XL</option>
    </select>
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>
