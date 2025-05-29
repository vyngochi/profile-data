<?php
session_start();
require_once "pdo.php";
require_once "util.php";

if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['headline'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    }
    $sql = "INSERT INTO Profile (first_name, last_name, headline, summary)
            VALUES (:first_name, :last_name, :headline, :summary)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary']
    ]);
    $_SESSION['success'] = "Profile added";
    header("Location: index.php");
    return;
}
?>
<html>
<head>
    <script src="script.js"></script>
</head>
<body>
<h1>Vy Ngo Chi - 161a79c2</h1>
<?php flashMessages(); ?>
<form method="post" onsubmit="return validateForm();">
    <p>First Name: <input type="text" name="first_name"></p>
    <p>Last Name: <input type="text" name="last_name"></p>
    <p>Headline: <input type="text" name="headline"></p>
    <p>Summary:<br/><textarea name="summary" rows="8" cols="80"></textarea></p>
    <p><input type="submit" value="Add"> <a href="index.php">Cancel</a></p>
</form>
</body>
</html>
ss