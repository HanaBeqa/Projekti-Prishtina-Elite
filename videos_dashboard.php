<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include "Video.php";
$videoObj = new Video();


if(isset($_GET['delete'])){
    $videoObj->delete($_GET['delete']);
    header("Location: videos_dashboard.php");
    exit;
}

if(isset($_POST['save'])){
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'];
    $description = $_POST['description'];
    $iframe_url = $_POST['iframe_url'];

    if($id){
        $videoObj->update($id, $title, $description, $iframe_url);
    } else {
        $videoObj->add($title, $description, $iframe_url);
    }

    header("Location: videos_dashboard.php");
    exit;
}

$videos = $videoObj->getAll();

$edit = ['id'=>'','title'=>'','description'=>'','iframe_url'=>''];
if(isset($_GET['edit'])){
    $edit = $videoObj->get($_GET['edit']);
    if(!$edit) $edit = ['id'=>'','title'=>'','description'=>'','iframe_url'=>''];
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
    <th>Title</th>
    <th>Description</th>
    <th>Iframe URL</th>
    <th>Actions</th>
</tr>

<?php foreach($videos as $v): ?>
<tr>
    <td><?= $v['id'] ?></td>
    <td><?= htmlspecialchars($v['title']) ?></td>
    <td><?= htmlspecialchars($v['description']) ?></td>
    <td><a href="<?= $v['iframe_url'] ?>" target="_blank">View iframe</a></td>
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
    <label>Title:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($edit['title']) ?>" required><br>
    <label>Description:</label><br>
    <textarea name="description"><?= htmlspecialchars($edit['description']) ?></textarea><br>
    <label>Iframe URL:</label><br>
    <input type="text" name="iframe_url" value="<?= htmlspecialchars($edit['iframe_url']) ?>" required><br>
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>
