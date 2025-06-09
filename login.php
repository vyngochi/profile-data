<?php
session_start();
require_once "pdo.php"; // cần để kết nối tới CSDL

$salt = 'XyZzy12*_';
$stored_hash = hash('md5', 'php123'.$salt); // pw: php123

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $check = hash('md5', $_POST['pass'].$salt);

    // Lấy user dựa trên email
    $stmt = $pdo->prepare("SELECT user_id, name FROM users WHERE email = :em");
    $stmt->execute([':em' => $_POST['email']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false && $check === $stored_hash) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id']; // ✅ Lưu user_id
        header("Location: index.php");
        return;
    } else {
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        return;
    }
}
?>
