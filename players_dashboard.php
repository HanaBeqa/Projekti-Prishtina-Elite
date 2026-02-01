<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include "Player.php";
$player = new Player();

if(isset($_GET['delete'])){
    $player->delete($_GET['delete']);
    header("Location: players_dashboard.php");
    exit;
}

if(isset($_POST['save'])){
    $id = $_POST['id'] ?? null;
    $full_name = $_POST['full_name'];
    $number = $_POST['number'];
    $position = $_POST['position'];
    $image = $_POST['image'];

    if($id){
        $player->update($id, $full_name, $number, $position, $image);
    } else {
        $player->add($full_name, $number, $position, $image);
    }
    header("Location: players_dashboard.php");
    exit;
}

$players = $player->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Players Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>

<h2>Players Dashboard</h2>
<a href="main_dashboard.php" id="back-link">Back to main dashboard</a>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>#</th>
    <th>Position</th>
    <th>Image</th>
    <th>Actions</th>
</tr>

<?php foreach($players as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['full_name'] ?></td>
    <td><?= $p['number'] ?></td>
    <td><?= $p['position'] ?></td>
    <td><?= $p['image'] ?></td>
    <td>
        <a href="?edit=<?= $p['id'] ?>">Edit</a> |
        <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php
$edit = ['id'=>'','full_name'=>'','number'=>'','position'=>'','image'=>''];
if(isset($_GET['edit'])){
    foreach($players as $p){
        if($p['id'] == $_GET['edit']){
            $edit = $p; break;
        }
    }
}
?>

<h3>Add / Edit Player</h3>
<form method="post">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <input type="text" name="full_name" placeholder="Player Name" value="<?= $edit['full_name'] ?>" required>
    <input type="number" name="number" placeholder="Jersey #" value="<?= $edit['number'] ?>" required>
    <input type="text" name="position" placeholder="Position" value="<?= $edit['position'] ?>" required>
    <input type="text" name="image" placeholder="Image filename" value="<?= $edit['image'] ?>" required>
    <button type="submit" name="save">Save</button>
</form>

</body>
</html>
