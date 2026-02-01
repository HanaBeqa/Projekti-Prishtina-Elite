<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include "Poster.php";
$posterObj = new Poster();


if(isset($_GET['delete'])){
    $poster = $posterObj->get($_GET['delete']);
    if($poster && file_exists($poster['image_path'])){
        unlink($poster['image_path']);
    }

    $posterObj->delete($_GET['delete']);
    header("Location: posters_dashboard.php");
    exit;
}


if(isset($_POST['save'])){
    $id = $_POST['id'] ?? null;

    
    if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0){
        $uploadDir = 'uploads_posters/';
        if(!is_dir($uploadDir)) mkdir($uploadDir);
        $image_path = $uploadDir . basename($_FILES['image_file']['name']);
        move_uploaded_file($_FILES['image_file']['tmp_name'], $image_path);
    } else {
        $image_path = $_POST['current_image'] ?? '';
    }

    if($id){
        $posterObj->update($id, $image_path);
    } else {
        $posterObj->add($image_path);
    }
    header("Location: posters_dashboard.php");
    exit;
}


$posters = $posterObj->getAll();


$edit = ['id'=>'','image_path'=>''];
if(isset($_GET['edit'])){
    $edit = $posterObj->get($_GET['edit']);
    if(!$edit) $edit = ['id'=>'','image_path'=>''];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Posters Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>
<h2>Posters Dashboard</h2>
<a href="main_dashboard.php" id="back-link">Back to main dashboard</a>

<table>
<tr>
    <th>ID</th>
    <th>Poster</th>
    <th>Preview</th>
    <th>Actions</th>
</tr>

<?php foreach($posters as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= htmlspecialchars($p['image_path']) ?></td>
    <td><img src="<?= $p['image_path'] ?>" width="100"></td>
    <td>
        <a href="?edit=<?= $p['id'] ?>">Edit</a> |
        <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Delete this poster?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit Poster</h3>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <input type="hidden" name="current_image" value="<?= $edit['image_path'] ?>">
    <?php if(!empty($edit['image_path'])): ?>
        <p>Current: <img src="<?= $edit['image_path'] ?>" width="100"></p>
    <?php endif; ?>
    <input type="file" name="image_file" <?= empty($edit['id']) ? 'required' : '' ?>>
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>
