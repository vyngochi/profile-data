<?php
session_start();
require_once "pdo.php";

$stmt = $pdo->query("SELECT profile_id, first_name, last_name, headline FROM Profile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Resume Registry</h1>

<?php
if (isset($_SESSION['success'])) {
    echo "<p style='color:green'>".$_SESSION['success']."</p>";
    unset($_SESSION['success']);
}
?>

<?php if (isset($_SESSION['name'])): ?>
    <a href="logout.php">Logout</a>
    <table>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><a href="view.php?profile_id=<?= $row['profile_id'] ?>"><?= htmlentities($row['first_name'].' '.$row['last_name']) ?></a></td>
                <td><?= htmlentities($row['headline']) ?></td>
                <td>
                    <a href="edit.php?profile_id=<?= $row['profile_id'] ?>">Edit</a> /
                    <a href="delete.php?profile_id=<?= $row['profile_id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="add.php">Add New Entry</a>
<?php else: ?>
    <a href="login.php">Please log in</a>
<?php endif; ?>
