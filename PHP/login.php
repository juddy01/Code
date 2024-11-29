<?php
session_start();
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "rentmycar";
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// testing database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// else grabbing value from form
$txtUserName = $_POST['txtUserName'];
$txtPWD = $_POST['txtPWD'];

// sql queries for username and password
$userCheck_SQL = "SELECT * FROM users WHERE username ='$txtUserName'";
$User_result = $conn->query($userCheck_SQL);
$pwdCheck_SQL = "SELECT * FROM users WHERE username ='$txtUserName' AND password ='$txtPWD'";
$pwd_result = $conn->query($pwdCheck_SQL);

// Validating user exists
if ($User_result->num_rows == 0) {
    // echo "Incorrect Username";
    header("location: http://localhost/code/HTML/registration.html?Unknown_User?");
    exit();
} elseif ($pwd_result->num_rows === 1) {
    $_SESSION['user'] = mysqli_fetch_row($pwd_result);
    header("location: http://localhost/code/HTML/" . $_SESSION["Page"] . "?is_logged_in=1?");
    exit();
} else {
    header("location: http://localhost/code/HTML/" . $_SESSION["Page"] . "?Invalid_Password?");
    exit();
}
?>
