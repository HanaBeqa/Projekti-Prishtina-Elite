<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include "Tickets.php";
$tickets = new Tickets();

if(isset($_GET['delete'])){
    $tickets->delete($_GET['delete']);
    header("Location: tickets_dashboard.php");
    exit;
}

if(isset($_POST['save'])){
    $id = $_POST['id'] ?? null;
    $user_name = $_POST['user_name'];
    $event_name = $_POST['event_name'];
    $quantity = $_POST['quantity'];
    $email = $_POST['email'];

    if($id){
        $tickets->update($id,$user_name,$event_name,$quantity,$email);
    } else {
        $tickets->add($user_name,$event_name,$quantity,$email);
    }
    header("Location: tickets_dashboard.php");
    exit;
}

$allTickets = $tickets->getAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tickets Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>
<h2>Tickets Orders Dashboard</h2>
<a href="dashboard.php">Back to main dashboard</a>
<table>
<tr><th>ID</th><th>User Name</th><th>Event</th><th>Quantity</th><th>Email</th><th>Actions</th></tr>
<?php foreach($allTickets as $t): ?>
<tr>
    <td><?= $t['id'] ?></td>
    <td><?= $t['user_name'] ?></td>
    <td><?= $t['event_name'] ?></td>
    <td><?= $t['quantity'] ?></td>
    <td><?= $t['email'] ?></td>
    <td>
        <a href="tickets_dashboard.php?edit=<?= $t['id'] ?>">Edit</a> |
        <a href="tickets_dashboard.php?delete=<?= $t['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit Ticket Order</h3>
<?php 
$editData = ['id'=>'','user_name'=>'','event_name'=>'','quantity'=>'','email'=>''];
if(isset($_GET['edit'])){
    foreach($allTickets as $t){
        if($t['id']==$_GET['edit']){
            $editData=$t; break;
        }
    }
}
?>
<form method="post">
    <input type="hidden" name="id" value="<?= $editData['id'] ?>">
    <input type="text" name="user_name" placeholder="User Name" value="<?= $editData['user_name'] ?>" required>
    <input type="text" name="event_name" placeholder="Event Name" value="<?= $editData['event_name'] ?>" required>
    <input type="number" name="quantity" placeholder="Quantity" value="<?= $editData['quantity'] ?>" required>
    <input type="email" name="email" placeholder="Email" value="<?= $editData['email'] ?>" required>
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>
