<?php
session_start();
require_once 'pdo.php';
require_once 'util.php';

// ✅ Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    die("ACCESS DENIED");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ✅ Kiểm tra dữ liệu trống
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) ||
        empty($_POST['headline']) || empty($_POST['summary'])) {
        $_SESSION['error'] = "All fields are required";
        header('Location: add.php');
        return;
    }

    // ✅ Kiểm tra định dạng email
    if (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header('Location: add.php');
        return;
    }

    // ✅ INSERT PROFILE
    $stmt = $pdo->prepare("
        INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary)
        VALUES (:user_id, :first_name, :last_name, :email, :headline, :summary)
    ");
    $stmt->execute(array(
        ':user_id' => $_SESSION['user_id'],
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary']
    ));

    $_SESSION['success'] = "Profile added";
    header('Location: index.php');
    return;
}
?>

<!DOCTYPE html>
<ht
