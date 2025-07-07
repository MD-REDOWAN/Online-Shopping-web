<?php
$host = 'localhost';
$dbname = 'meherab';
$user = 'root'; // Change this to your MySQL username
$pass = ''; // Change this to your MySQL password

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$user=null;


// Check if user is already logged in via cookie
if (isset($_COOKIE['user_token'])) {
    $token = $_COOKIE['user_token'];
    // Look up the token in the database to identify the user
    $sql = "SELECT id, username FROM users WHERE token = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
        // User found, redirect to welcome page
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        //header('Location: welcome.php');
        //exit();
    } else {
        // Token is invalid, delete cookie
        setcookie('user_token', '', time() - 3600, '/');
    }
}
?>
