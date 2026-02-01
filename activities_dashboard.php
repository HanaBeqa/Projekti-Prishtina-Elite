<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include "Activity.php";
$activityObj = new Activity();

// DELETE
if(isset($_GET['delete'])){
    $activityObj->delete($_GET['delete']);
    header("Location: activities_dashboard.php");
    exit;
}

// ADD / UPDATE
if(isset($_POST['save'])){
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'];
    $description = $_POST['description'];
    $images = $_POST['images']; // lista e imazheve me presje

    if($id){
        $activityObj->update($id, $title, $description, $images);
    } else {
        $activityObj->add($title, $description, $images);
    }
    header("Location: activities_dashboard.php");
    exit;
}

// Fetch all
$activities = $activityObj->getAll();

// Edit mode
$edit = ['id'=>'','title'=>'','description'=>'','images'=>''];
if(isset($_GET['edit'])){
    $edit = $activityObj->get($_GET['edit']);
    if(!$edit) $edit = ['id'=>'','title'=>'','description'=>'','images'=>''];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Activities Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>

<h2>Activities Dashboard</h2>
<a href="main_dashboard.php" id="back-link">Back to main dashboard</a>

<table>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Images</th>
    <th>Actions</th>
</tr>

<?php foreach($activities as $a): ?>
<tr>
    <td><?= $a['id'] ?></td>
    <td><?= htmlspecialchars($a['title']) ?></td>
    <td><?= htmlspecialchars(substr($a['description'],0,100)) ?>...</td>
    <td><?= htmlspecialchars($a['images']) ?></td>
    <td>
        <a href="?edit=<?= $a['id'] ?>">Edit</a> |
        <a href="?delete=<?= $a['id'] ?>" onclick="return confirm('Delete this activity?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit Activity</h3>
<form method="post">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($edit['title']) ?>" required><br>
    <label>Description:</label><br>
    <textarea name="description" rows="5" required><?= htmlspecialchars($edit['description']) ?></textarea><br>
    <label>Images (comma-separated):</label><br>
    <input type="text" name="images" value="<?= htmlspecialchars($edit['images']) ?>" required><br>
    <button type="submit" name="save">Save</button>
</form>

</body>
</html>
