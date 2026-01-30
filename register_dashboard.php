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
    $full_name = $_POST['full_name'];
    $parent_name = $_POST['parent_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $school = $_POST['school'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if($id){
        $register->update($id, $full_name, $parent_name, $age, $gender, $school, $email, $phone);
    } else {
        $register->add($full_name, $parent_name, $age, $gender, $school, $email, $phone);
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
<a href="main_dashboard.php">Back to main dashboard</a>
<table>
<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Parent Name</th>
    <th>Age</th>
    <th>Gender</th>
    <th>School</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Actions</th>
</tr>
<?php foreach($allRegisters as $r): ?>
<tr>
    <td><?= $r['id'] ?></td>
    <td><?= $r['full_name'] ?></td>
    <td><?= $r['parent_name'] ?></td>
    <td><?= $r['age'] ?></td>
    <td><?= $r['gender'] ?></td>
    <td><?= $r['school'] ?></td>
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
$editData = ['id'=>'','full_name'=>'','parent_name'=>'','age'=>'','gender'=>'','school'=>'','email'=>'','phone'=>''];
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
    <input type="text" name="full_name" placeholder="Full Name" value="<?= $editData['full_name'] ?>" required>
    <input type="text" name="parent_name" placeholder="Parent Name" value="<?= $editData['parent_name'] ?>" required>
    <input type="number" name="age" placeholder="Age" value="<?= $editData['age'] ?>" required>
    <select name="gender" required>
        <option value="">Select Gender</option>
        <option value="Male" <?= $editData['gender']=='Male'?'selected':'' ?>>Male</option>
        <option value="Female" <?= $editData['gender']=='Female'?'selected':'' ?>>Female</option>
    </select>
    <select name="school" required>
        <option value="">Select School</option>
        <option value="Ballon Salla" <?= $editData['school']=='Ballon Salla'?'selected':'' ?>>Ballon Salla</option>
        <option value="Dardania" <?= $editData['school']=='Dardania'?'selected':'' ?>>Dardania</option>
        <option value="Iliria" <?= $editData['school']=='Iliria'?'selected':'' ?>>Iliria</option>
        <option value="Pavarsia" <?= $editData['school']=='Pavarsia'?'selected':'' ?>>Pavarsia</option>
        <option value="Mehmet Xhevori" <?= $editData['school']=='Mehmet Xhevori'?'selected':'' ?>>Mehmet Xhevori</option>
    </select>
    <input type="email" name="email" placeholder="Email" value="<?= $editData['email'] ?>" required>
    <input type="text" name="phone" placeholder="Phone" value="<?= $editData['phone'] ?>">
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>

