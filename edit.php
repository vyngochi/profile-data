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

$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :id");
$stmt->execute([':id' => $_GET['profile_id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $_SESSION['error'] = "Bad value for profile_id";
    header("Location: index.php");
    return;
}

if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['headline'], $_POST['summary'])) {
    $sql = "UPDATE Profile SET first_name = :first, last_name = :last, email = :email,
            headline = :headline, summary = :summary WHERE profile_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':first' => $_POST['first_name'],
        ':last' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary'],
        ':id' => $_GET['profile_id'],
    ]);
    $_SESSION['success'] = "Profile updated";
    header("Location: index.php");
    return;
}
?>

<form method="post" onsubmit="return validateForm();">
    <script src="util.js"></script>
    First Name: <input type="text" name="first_name" value="<?= htmlentities($row['first_name']) ?>"><br/>
    Last Name: <input type="text" name="last_name" value="<?= htmlentities($row['last_name']) ?>"><br/>
    Email: <input type="text" name="email" value="<?= htmlentities($row['email']) ?>"><br/>
    Headline: <input type="text" name="headline" value="<?= htmlentities($row['headline']) ?>"><br/>
    Summary:<br/>
    <textarea name="summary" rows="8" cols="80"><?= htmlentities($row['summary']) ?></textarea><br/>
    <input type="submit" value="Save">
    <a href="index.php">Cancel</a>
</form>
