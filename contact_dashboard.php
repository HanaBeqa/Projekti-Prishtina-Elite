<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include "Contact.php";
$contact = new Contact();

if(isset($_GET['delete'])){
    $contact->delete($_GET['delete']);
    header("Location: contact_dashboard.php");
    exit;
}

if(isset($_POST['save'])){
    $id = $_POST['id'] ?? null;
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if($id){
        $contact->update($id,$user_name,$email,$message);
    } else {
        $contact->add($user_name,$email,$message);
    }
    header("Location: contact_dashboard.php");
    exit;
}

$allContacts = $contact->getAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>
<h2>Contact Messages Dashboard</h2>
<a href="dashboard.php">Back to main dashboard</a>
<table>
<tr><th>ID</th><th>User Name</th><th>Email</th><th>Message</th><th>Actions</th></tr>
<?php foreach($allContacts as $c): ?>
<tr>
    <td><?= $c['id'] ?></td>
    <td><?= $c['user_name'] ?></td>
    <td><?= $c['email'] ?></td>
    <td><?= $c['message'] ?></td>
    <td>
        <a href="contact_dashboard.php?edit=<?= $c['id'] ?>">Edit</a> |
        <a href="contact_dashboard.php?delete=<?= $c['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit Contact Message</h3>
<?php 
$editData = ['id'=>'','user_name'=>'','email'=>'','message'=>''];
if(isset($_GET['edit'])){
    foreach($allContacts as $c){
        if($c['id']==$_GET['edit']){
            $editData=$c; break;
        }
    }
}
?>
<form method="post">
    <input type="hidden" name="id" value="<?= $editData['id'] ?>">
    <input type="text" name="user_name" placeholder="User Name" value="<?= $editData['user_name'] ?>" required>
    <input type="email" name="email" placeholder="Email" value="<?= $editData['email'] ?>" required>
    <textarea name="message" placeholder="Message" required><?= $editData['message'] ?></textarea>
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>
