<?php
session_start();
require_once "pdo.php";
require_once "util.php";

  // The login check and redirect block was removed because it is not relevant in add.php.
  // Make sure user authentication is handled elsewhere (e.g., in login.php or a middleware).

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['headline'])) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    }
    
    $query = $pdo->prepare("INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) VALUES (:user_id, :first_name, :last_name, :email, :headline, :summary)");
    $query->execute(array(
        ':user_id' => $_SESSION['user_id'],
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary']
    ));
      if ($row !== false) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];  // ✅ Đây là dòng quan trọng
        header("Location: index.php");
        return;
    } else {
        $_SESSION['error'] = "Incorrect login";
        header("Location: login.php");
        return;
    }
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
    <p>Email: <input type="text" name="email"></p>
    <p>Headline: <input type="text" name="headline"></p>
    <p>Summary:<br/><textarea name="summary" rows="8" cols="80"></textarea></p>
    <p><input type="submit" value="Add"> <a href="index.php">Cancel</a></p>
</form>
</body>
</html>
