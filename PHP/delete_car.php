<?php
session_start();
include('db_connection.php'); 

if (isset($_POST['vehicle_id'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $userid = ($_SESSION['user'][0]); // Assuming user ID is stored in session

    // Check if the user is the owner of the vehicle
    $sql = "SELECT * FROM vehicle_details WHERE id = '$vehicle_id' AND User_id = '$userid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Delete the vehicle record
        $sql_delete = "DELETE FROM vehicle_details WHERE id = '$vehicle_id' AND User_id = '$userid'";
        if ($conn->query($sql_delete) === TRUE) {
            echo "Car deleted successfully.";
        } else {
            echo "Error deleting car: " . $conn->error;
        }
    } else {
        echo "You are not authorized to delete this car.";
    }
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
