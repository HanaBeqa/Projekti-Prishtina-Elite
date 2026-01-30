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
    $full_name = $_POST['full_name'];
    $team = $_POST['team'];
    $quantity = $_POST['quantity'];
    $seat_type = $_POST['seat_type'];

    if($id){
        $tickets->update($id,$full_name,$team,$quantity,$seat_type);
    } else {
        $tickets->add($full_name,$team,$quantity,$seat_type);
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
<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Team</th>
    <th>Quantity</th>
    <th>Seat Type</th>
    <th>Actions</th>
</tr>
<?php foreach($allTickets as $t): ?>
<tr>
    <td><?= $t['id'] ?></td>
    <td><?= $t['full_name'] ?></td>
    <td><?= $t['team'] ?></td>
    <td><?= $t['quantity'] ?></td>
    <td><?= $t['seat_type'] ?></td>
    <td>
        <a href="tickets_dashboard.php?edit=<?= $t['id'] ?>">Edit</a> |
        <a href="tickets_dashboard.php?delete=<?= $t['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit Ticket Order</h3>
<?php
$editData = ['id'=>'','full_name'=>'','team'=>'','quantity'=>'','seat_type'=>''];
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
    <input type="text" name="full_name" placeholder="Full Name" value="<?= $editData['full_name'] ?>" required>
    <select name="team" required>
        <option value="">Select Team</option>
        <option value="Team A" <?= $editData['team']=='Team A'?'selected':'' ?>>Team A</option>
        <option value="Team B" <?= $editData['team']=='Team B'?'selected':'' ?>>Team B</option>
    </select>
    <input type="number" name="quantity" placeholder="Quantity" value="<?= $editData['quantity'] ?>" required>
    <select name="seat_type" required>
        <option value="">Select Seat Type</option>
        <option value="Regular" <?= $editData['seat_type']=='Regular'?'selected':'' ?>>Regular</option>
        <option value="VIP" <?= $editData['seat_type']=='VIP'?'selected':'' ?>>VIP</option>
        <option value="Premium" <?= $editData['seat_type']=='Premium'?'selected':'' ?>>Premium</option>
    </select>
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>

