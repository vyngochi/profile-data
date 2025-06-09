<?php
session_start();
require_once "pdo.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

// Handle cancel button
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate fields
    if (
        empty($_POST['first_name']) || empty($_POST['last_name']) ||
        empty($_POST['email']) || empty($_POST['headline']) || empty($_POST['summary'])
    ) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    }

    if (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = "Email address must contain @";
        header("Location: add.php");
        return;
    }

    // Insert into database
    $stmt = $pdo->prepare('INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary)
                           VALUES (:uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute([
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'],
    ]);

    // Flash success message
    $_SESSION['success'] = "Profile added";
    header("Location: index.php");
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vỹ Ngô Chí - Add Profile 161a79c2</title>
</head>
<body>
<h1>Adding Profile for <?= htmlentities($_SESSION['name']) ?></h1>
<?php
if (isset($_SESSION['error'])) {
    echo '<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>";
    unset($_SESSION['error']);
}
?>
<form method="post">
    <p>First Name: <input type="text" name="first_name"></p>
    <p>Last Name: <input type="text" name="last_name"></p>
    <p>Email: <input type="text" name="email"></p>
    <p>Headline:<br><input type="text" name="headline"></p>
    <p>Summary:<br><textarea name="summary" rows="8" cols="80"></textarea></p>
    <p>
        <input type="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel">
    </p>
</form>
</body>
</html>
