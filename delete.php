<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing profile_id";
    header("Location: index.php");
    return;
}

if (isset($_POST['delete']) && isset($_POST['profile_id'])) {
    $stmt = $pdo->prepare("DELETE FROM Profile WHERE profile_id = :id");
    $stmt->execute([':id' => $_POST['profile_id']]);
    $_SESSION['success'] = "Profile deleted";
    header("Location: index.php");
    return;
}

$stmt = $pdo->prepare("SELECT first_name, last_name FROM Profile WHERE profile_id = :id");
$stmt->execute([':id' => $_GET['profile_id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $_SESSION['error'] = "Bad value for profile_id";
    header("Location: index.php");
    return;
}
?>

<p>Confirm deletion of: <?= htmlentities($row['first_name'] . ' ' . $row['last_name']) ?></p>

<form method="post">
    <input type="hidden" name="profile_id" value="<?= htmlentities($_GET['profile_id']) ?>">
    <input type="submit" name="delete" value="Delete">
    <a href="index.php">Cancel</a>
</form>
