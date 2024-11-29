<?php
session_start();
include('../php/conn.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user'])) {
    die("Access denied. Please log in.");
}

$user_id = $_SESSION['user'][0];
$vehicle_id = $_GET['vehicle_id'];

$sql = "SELECT * FROM vehicle_details WHERE vehicle_id = '$vehicle_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Car not found.");
}

$row = $result->fetch_assoc();

echo $user_id;
echo ($row['user_id']);

if ($row['User_id'] != $user_id) {
    die("Access denied. You do not have permission to edit this car.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $vehicleMake = $_POST['vehicle_make'];
        $vehicleModel = $_POST['vehicle_model'];
        $vehicleBodytype = $_POST['vehicle_bodytype'];
        $fuelType = $_POST['fuelType'];
        $mileage = $_POST['mileage'];
        $location = $_POST['location'];
        $year = $_POST['year'];
        $numDoors = $_POST['num_doors'];

        $sql_update = "UPDATE vehicle_details SET vehicle_make=?, vehicle_model=?, vehicle_bodytype=?, fuel_type=?, mileage=?, location=?, year=?, num_doors=? WHERE id=?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssissii", $vehicleMake, $vehicleModel, $vehicleBodytype, $fuelType, $mileage, $location, $year, $numDoors, $vehicle_id
);
        if ($stmt_update->execute()) {
            echo "Car details updated successfully.";
        } else {
            echo "Error updating record: " . $stmt_update->error;
        }
    } elseif (isset($_POST['delete'])) {
        $sql_delete = "DELETE FROM vehicle_details WHERE id=?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $vehicle_id
);
        if ($stmt_delete->execute()) {
            echo "Car deleted successfully.";
        } else {
            echo "Error deleting record: " . $stmt_delete->error;
        }
        header("Location: your_redirection_page.php"); // Redirect after deletion
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
</head>
<body>
    <h1>Edit Car Details</h1>
    <form method="post">
        <label for="vehicle_make">Vehicle Make:</label>
        <input type="text" id="vehicle_make" name="vehicle_make" value="<?php echo htmlspecialchars($row['vehicle_make']); ?>" required><br>

        <label for="vehicle_model">Vehicle Model:</label>
        <input type="text" id="vehicle_model" name="vehicle_model" value="<?php echo htmlspecialchars($row['vehicle_model']); ?>" required><br>

        <label for="vehicle_bodytype">Vehicle Bodytype:</label>
        <input type="text" id="vehicle_bodytype" name="vehicle_bodytype" value="<?php echo htmlspecialchars($row['vehicle_bodytype']); ?>" required><br>

        <label for="fuelType">Fuel Type:</label>
        <input type="text" id="fuelType" name="fuelType" value="<?php echo htmlspecialchars($row['fuel_type']); ?>" required><br>

        <label for="mileage">Mileage:</label>
        <input type="number" id="mileage" name="mileage" value="<?php echo htmlspecialchars($row['mileage']); ?>" required><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" required><br>

        <label for="year">Year:</label>
        <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($row['year']); ?>" required><br>

        <label for="num_doors">Number of Doors:</label>
        <input type="number" id="num_doors" name="num_doors" value="<?php echo htmlspecialchars($row['num_doors']); ?>" required><br>

        <input type="submit" name="update" value="Update Car Details">
        <input type="submit" name="delete" value="Delete Car">
    </form>
</body>
</html>
