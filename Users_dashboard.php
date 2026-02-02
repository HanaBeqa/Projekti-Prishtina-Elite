<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['role'] != 'admin'){
    header("Location: home.php");
    exit;
}

include "Users.php";
$usersObj = new Users();

if(isset($_GET['delete'])){
    $usersObj->delete($_GET['delete']);
    header("Location: users_dashboard.php");
    exit;
}

if(isset($_POST['save'])){
    $id = $_POST['id'] ?? null;
    $username = $_POST['username'];
    $password = $_POST['password'] ?? null;
    $role = $_POST['role'] ?? 'user';

    if($id){
        $usersObj->update($id, $username, $password, $role);
    } else {
        $usersObj->add($username, $password, $role);
    }

    header("Location: users_dashboard.php");
    exit;
}

$users = $usersObj->getAll();

$edit = ['id'=>'','username'=>'','role'=>'user'];
if(isset($_GET['edit'])){
    $edit = $usersObj->get($_GET['edit']);
    if(!$edit) $edit = ['id'=>'','username'=>'','role'=>'user'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>
<h2>Users Dashboard</h2>
<a href="main_dashboard.php" id="back-link">Back to main dashboard</a>

<table>
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Role</th>
    <th>Created At</th>
    <th>Actions</th>
</tr>

<?php foreach($users as $u): ?>
<tr>
    <td><?= $u['id'] ?></td>
    <td><?= htmlspecialchars($u['username']) ?></td>
    <td><?= $u['role'] ?></td>
    <td><?= $u['created_at'] ?></td>
    <td>
        <a href="?edit=<?= $u['id'] ?>">Edit</a> |
        <a href="?delete=<?= $u['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h3>Add / Edit User</h3>
<form method="post">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">

    <p>
        <label>Username:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($edit['username']) ?>" required>
    </p>
    <p>
        <label>Password:</label>
        <input type="password" name="password" <?= empty($edit['id']) ? 'required' : '' ?>>
        <?php if(!empty($edit['id'])) echo "(Leave empty to keep current password)"; ?>
    </p>
    <p>
        <label>Role:</label>
        <select name="role">
            <option value="user" <?= $edit['role']=='user'?'selected':'' ?>>User</option>
            <option value="admin" <?= $edit['role']=='admin'?'selected':'' ?>>Admin</option>
        </select>
    </p>
    <button type="submit" name="save">Save</button>
</form>
</body>
</html>
