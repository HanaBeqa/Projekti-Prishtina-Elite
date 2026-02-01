<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include_once "Video.php";
$videoObj = new Video();


if(isset($_GET['delete'])){
    $videoObj->delete($_GET['delete']);
    header("Location: videos_dashboard.php");
    exit;
}


if(isset($_POST['save'])){
    $id = $_POST['id'] ?? null;
    $iframe = $_POST['iframe'] ?? '';
    $description = $_POST['description'] ?? '';
    $date = $_POST['date_created'] ?? date('Y-m-d');

    if($id){
        $videoObj->update($id, $iframe, $description, $date);
    } else {
        $videoObj->add($iframe, $description, $date);
    }
    header("Location: videos_dashboard.php");
    exit;
}

$videos = $videoObj->getAll();
$edit = ['id'=>'','iframe'=>'','description'=>'','date_created'=>''];
if(isset($_GET['edit'])){
    $edit = $videoObj->get($_GET['edit']);
    if(!$edit) $edit = ['id'=>'','iframe'=>'','description'=>'','date_created'=>''];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Videos Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>
<h2>Videos Dashboard</h2>
<a href="main_dashboard.php" id="back-link">Back to main dashboard</a>

<table>
<tr>
    <th>ID</th>
    <th>Iframe</th>
    <th>Description</th>
    <th>Date</th>
    <th>Actions</th>
</tr>
<?php foreach($videos as $v): ?>
<tr>
    <td><?= $v['id'] ?></td>
    <td><?= htmlspecialchars($v['iframe']) ?></td>
    <td><?= htmlspecialchars($v['description']) ?></td>
    <td><?= $v['date_created'] ?></td>
    <td>
        <a href="?edit=<?= $v['id'] ?>">Edit</a> |
        <a href="?delete=<?= $v['id'] ?>" onclick="return confirm('Delete this video?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit Video</h3>
<form method="post">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <p>Iframe embed code:</p>
    <textarea name="iframe" required><?= htmlspecialchars($edit['iframe']) ?></textarea>
    <p>Description:</p>
    <input type="text" name="description" value="<?= htmlspecialchars($edit['description']) ?>">
    <p>Date:</p>
    <input type="date" name="date_created" value="<?= $edit['date_created'] ?: date('Y-m-d') ?>">
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>
