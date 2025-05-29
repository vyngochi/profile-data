<?php
session_start();
require_once 'pdo.php';
require_once 'util.php';

if (!isset($_SESSION['user_id'])) {
	$_SESSION['error'] = "Access denied. Please login first.";
	header('Location: index.php');
	return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


	// INSERT PROFILE
	$query = $pdo->prepare("INSERT INTO profiles (user_id, first_name, last_name, email, headline, summary) VALUES (:user_id, :first_name, :last_name, :email, :headline, :summary)");
	$query->execute(array(
		':user_id' => $_SESSION['user_id'],
		':first_name' => $_POST['first_name'],
		':last_name' => $_POST['last_name'],
		':email' => $_POST['email'],
		':headline' => $_POST['headline'],
		':summary' => $_POST['summary']
	));
    $profile_id = $pdo->lastInsertId();

}

$_SESSION['countPos'] = 0;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Vy Ngo Chi - 161a79c2</title>
</head>
<body>
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
