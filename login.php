<?php
session_start();
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = hash('md5', $salt.'php123');

if (isset($_POST['email']) && isset($_POST['pass'])) {
    if (hash('md5', $salt.$_POST['pass']) == $stored_hash) {
        $_SESSION['name'] = $_POST['email'];
        header("Location: index.php");
        return;
    } else {
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        return;
    }
}
?>
<html>
<body>
<h1>Please Log In</h1>
<?php flashMessages(); ?>
<form method="post">
    <label for="email">Email</label>
    <input type="text" name="email"><br/>
    <label for="pass">Password</label>
    <input type="password" name="pass"><br/>
    <input type="submit" value="Log In">
    <input type="submit" name="cancel" value="Cancel">
</form>
</body>
</html>
