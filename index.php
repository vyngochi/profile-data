<?php
session_start();
require_once "pdo.php";
?>
<html>
<head>
    <title>Vy Ngo Chi - 161a79c2</title>
</head>
<body>
<h1>Welcome to the Profile Database</h1>
<?php flashMessages(); ?>
<?php
$stmt = $pdo->query("SELECT profile_id, first_name, last_name FROM Profile");
echo "<ul>\n";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<li>";
    echo '<a href="view.php?profile_id='.$row['profile_id'].'">';
    echo htmlentities($row['first_name'].' '.$row['last_name']);
    echo "</a> ";
    if (isset($_SESSION['name'])) {
        echo '<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> ';
        echo '<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>';
    }
    echo "</li>\n";
}
echo "</ul>\n";
if (isset($_SESSION['name'])) {
    echo '<p><a href="add.php">Add New Entry</a></p>';
    echo '<p><a href="logout.php">Logout</a></p>';
} else {
    echo '<p><a href="login.php">Please log in</a></p>';
}
?>
</body>
</html>
