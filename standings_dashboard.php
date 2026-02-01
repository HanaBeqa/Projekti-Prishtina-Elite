<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include "Standing.php";
$standing = new Standing();

if(isset($_GET['delete'])){
    $standing->delete($_GET['delete']);
    header("Location: standings_dashboard.php");
    exit;
}

if(isset($_POST['save'])){
    $id     = $_POST['id'] ?? null;
    $name   = $_POST['name'];
    $points = $_POST['points'];
    $played = $_POST['played'];
    $won    = $_POST['won'];
    $lost   = $_POST['lost'];

    if($id){
        $standing->update($id, $name, $points, $played, $won, $lost);
    } else {
        $standing->add($name, $points, $played, $won, $lost);
    }
    header("Location: standings_dashboard.php");
    exit;
}

$allStandings = $standing->getAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Standings Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>

<h2>Standings Dashboard</h2>
<a href="main_dashboard.php" id="back-link">Back to main dashboard</a>

<table>
<tr>
    <th>ID</th>
    <th>Team</th>
    <th>Points</th>
    <th>Played</th>
    <th>Won</th>
    <th>Lost</th>
    <th>Actions</th>
</tr>

<?php foreach($allStandings as $s): ?>
<tr>
    <td><?= $s['id'] ?></td>
    <td><?= htmlspecialchars($s['name']) ?></td>
    <td><?= $s['points'] ?></td>
    <td><?= $s['played'] ?></td>
    <td><?= $s['won'] ?></td>
    <td><?= $s['lost'] ?></td>
    <td>
        <a href="standings_dashboard.php?edit=<?= $s['id'] ?>">Edit</a> |
        <a href="standings_dashboard.php?delete=<?= $s['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit Standing</h3>

<?php
$editData = ['id'=>'','name'=>'','points'=>'','played'=>'','won'=>'','lost'=>''];
if(isset($_GET['edit'])){
    foreach($allStandings as $s){
        if($s['id'] == $_GET['edit']){
            $editData = $s;
            break;
        }
    }
}
?>

<form method="post">
    <input type="hidden" name="id" value="<?= $editData['id'] ?>">

    <input type="text" name="name" placeholder="Team Name"
           value="<?= $editData['name'] ?>" required>

    <input type="number" name="points" placeholder="Points"
           value="<?= $editData['points'] ?>" required>

    <input type="number" name="played" placeholder="Played"
           value="<?= $editData['played'] ?>" required>

    <input type="number" name="won" placeholder="Won"
           value="<?= $editData['won'] ?>" required>

    <input type="number" name="lost" placeholder="Lost"
           value="<?= $editData['lost'] ?>" required>

    <button type="submit" name="save">Save</button>
</form>

</body>
</html>
