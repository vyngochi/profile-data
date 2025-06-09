<?php
session_start();
require_once "pdo.php"; // Kết nối CSDL

$salt = 'XyZzy12*_';
$stored_hash = hash('md5', 'php123'.$salt); // Mật khẩu hợp lệ là: php123

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $check = hash('md5', $_POST['pass'].$salt);

    // Tìm người dùng theo email
    $stmt = $pdo->prepare("SELECT user_id, name, email FROM users WHERE email = :em");
    $stmt->execute([':em' => $_POST['email']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra nếu người dùng tồn tại và mật khẩu đúng
    if ($row !== false && $check === $stored_hash) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
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
<!DOCTYPE html>
<html>
<head>
    <title>Login - 161a79c2</title>
</head>
<body>
    <h1>Please Log In</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red">'.htmlentities($_SESSION['error'])."</p>\n";
        unset($_SESSION['error']);
    }
    ?>
    <form method="post">
        Email: <input type="text" name="email"><br/>
        Password: <input type="password" name="pass"><br/>
        <input type="submit" value="Log In">
    </form>
</body>
</html>
