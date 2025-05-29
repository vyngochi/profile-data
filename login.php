<?php
session_start();
$salt = 'XyZzy12*_';
$stored_hash = hash('md5', 'php123'.$salt); // pw: php123

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $check = hash('md5', $_POST['pass'].$salt);
    if ($check === $stored_hash) {
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

<!-- HTML Form -->
<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error'] ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form method="post">
    Email: <input type="text" name="email"><br/>
    Password: <input type="password" name="pass"><br/>
    <input type="submit" value="Log In">
</form>
