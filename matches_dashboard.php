<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include "Matches.php";
$matchesObj = new Matches();


if(isset($_GET['delete'])){
    $match = $matchesObj->get($_GET['delete']);
    if($match && file_exists($match['image_path'])){
        unlink($match['image_path']);
    }
    $matchesObj->delete($_GET['delete']);
    header("Location: matches_dashboard.php");
    exit;
}


if(isset($_POST['save'])){
    $id = $_POST['id'] ?? null;

    if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0){
        $uploadDir = 'uploads_matches/';
        if(!is_dir($uploadDir)) mkdir($uploadDir);
        $image_path = $uploadDir . basename($_FILES['image_file']['name']);
        move_uploaded_file($_FILES['image_file']['tmp_name'], $image_path);
    } else {
        $image_path = $_POST['current_image'] ?? '';
    }

    $team_opponent = $_POST['team_opponent'];
    $match_date = $_POST['match_date'] ?? null;

    if($id){
        $matchesObj->update($id, $team_opponent, $image_path, $match_date);
    } else {
        $matchesObj->add($team_opponent, $image_path, $match_date);
    }
    header("Location: matches_dashboard.php");
    exit;
}

$matches = $matchesObj->getAll();

$edit = ['id'=>'','team_opponent'=>'','image_path'=>'','match_date'=>''];
if(isset($_GET['edit'])){
    $edit = $matchesObj->get($_GET['edit']);
    if(!$edit) $edit = ['id'=>'','team_opponent'=>'','image_path'=>'','match_date'=>''];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Matches Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>
<h2>Matches Dashboard</h2>
<a href="main_dashboard.php" id="back-link">Back to main dashboard</a>

<table>
<tr>
    <th>ID</th>
    <th>Opponent</th>
    <th>Image Path</th>
    <th>Preview</th>
    <th>Date</th>
    <th>Actions</th>
</tr>

<?php foreach($matches as $m): ?>
<tr>
    <td><?= $m['id'] ?></td>
    <td><?= htmlspecialchars($m['team_opponent']) ?></td>
    <td><?= htmlspecialchars($m['image_path']) ?></td>
    <td><img src="<?= $m['image_path'] ?>" width="100"></td>
    <td><?= $m['match_date'] ?></td>
    <td>
        <a href="?edit=<?= $m['id'] ?>">Edit</a> |
        <a href="?delete=<?= $m['id'] ?>" onclick="return confirm('Delete this match?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit Match</h3>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <input type="hidden" name="current_image" value="<?= $edit['image_path'] ?>">

    <p>
        <label>Opponent Team:</label>
        <input type="text" name="team_opponent" value="<?= htmlspecialchars($edit['team_opponent']) ?>" required>
    </p>
    <p>
        <label>Match Date:</label>
        <input type="date" name="match_date" value="<?= $edit['match_date'] ?>">
    </p>
    <?php if(!empty($edit['image_path'])): ?>
        <p>Current Image: <img src="<?= $edit['image_path'] ?>" width="100"></p>
    <?php endif; ?>
    <p>
        <input type="file" name="image_file" <?= empty($edit['id']) ? 'required' : '' ?>>
    </p>
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>
