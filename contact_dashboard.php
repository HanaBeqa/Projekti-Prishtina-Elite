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
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if($id){
        $contact->update($id, $full_name, $email, $phone, $subject, $message);
    } else {
        $contact->add($full_name, $email, $phone, $subject, $message);
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
<a href="main_dashboard.php">Back to main dashboard</a>
<table>
<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Subject</th>
    <th>Message</th>
    <th>Actions</th>
</tr>
<?php foreach($allContacts as $c): ?>
<tr>
    <td><?= $c['id'] ?></td>
    <td><?= $c['full_name'] ?></td>
    <td><?= $c['email'] ?></td>
    <td><?= $c['phone'] ?></td>
    <td><?= $c['subject'] ?></td>
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
$editData = ['id'=>'','full_name'=>'','email'=>'','phone'=>'','subject'=>'','message'=>''];
if(isset($_GET['edit'])){
    foreach($allContacts as $c){
        if($c['id']==$_GET['edit']){
            $editData = $c; break;
        }
    }
}
?>
<form method="post">
    <input type="hidden" name="id" value="<?= $editData['id'] ?>">
    <input type="text" name="full_name" placeholder="Full Name" value="<?= $editData['full_name'] ?>" required>
    <input type="email" name="email" placeholder="Email" value="<?= $editData['email'] ?>" required>
    <input type="text" name="phone" placeholder="Phone" value="<?= $editData['phone'] ?>">
    <input type="text" name="subject" placeholder="Subject" value="<?= $editData['subject'] ?>">
    <textarea name="message" placeholder="Message" required><?= $editData['message'] ?></textarea>
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>
