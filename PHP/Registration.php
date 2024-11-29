<?php
$errors = 0;
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "rentmycar";
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// testing database connection
if ($conn->connect_error) {
    echo "Connection failed";
} else {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $title = $_POST['title'];
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $sex = $_POST['gender'];
    $address1 = $_POST['adress1'];
    $address2 = $_POST['adress2'];
    $address3 = $_POST['adress3'];
    $postcode = $_POST['postcode'];
    $description = $_POST['description'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    

    $target_file = $_FILES["profile_blob"]["name"];
    $tempname = $_FILES['profile_blob']['tmp_name'];
    $target_dir = "../uploads/users/".$username;
    $target_filepath = $target_dir."/".$target_file;

    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            die('Failed to create directories');
        }
    } else {
        echo 'Directory already exists.';
    }

    $sql_insert = "INSERT INTO users (username, password, title, first_name, last_name, gender, adress1, adress2, adress3, postcode, description, email, telephone, profile_blob, profile_url) VALUES ('$username', '$password', '$title', '$firstname', '$lastname', '$sex', '$address1', '$address2', '$address3', '$postcode', '$description', '$email', '$telephone', '$target_filepath', '$target_filepath');";

    $sql_usernamecheck = "SELECT * FROM users WHERE username ='$username'";
    $sql_usernameresult = $conn->query($sql_usernamecheck);

    if ($sql_usernameresult->num_rows >= 1) {
        echo "No value recorded, username already exists";
    } elseif ($conn->query($sql_insert) === TRUE) {
        echo "New record created successfully";
        if (move_uploaded_file($tempname, $target_filepath)) {
            echo "file uploaded";
        }
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
