<?php
session_start();
require '../PHP/conn.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$car_id = $_GET['vehicle_id'];

$sql = "SELECT * FROM vehicle_details WHERE vehicle_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Car not found.");
}

$row = $result->fetch_assoc();

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'][0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user'])) {
    if (isset($_POST['update']) && $row['user_id'] == $user_id) {
        $vehicleMake = $_POST['vehicle_make'];
        $vehicleModel = $_POST['vehicle_model'];
        $vehicleBodytype = $_POST['vehicle_bodytype'];
        $fuelType = $_POST['fuelType'];
        $mileage = $_POST['mileage'];
        $location = $_POST['location'];
        $year = $_POST['year'];
        $numDoors = $_POST['num_doors'];

        $sql_update = "UPDATE vehicle_details SET vehicle_make=?, vehicle_model=?, vehicle_bodytype=?, fuel_type=?, mileage=?, location=?, year=?, num_doors=? WHERE vehicle_id=?";
        $stmt_update = $conn->prepare($sql_update);
        if ($stmt_update === false) {
            die("Error preparing the update statement: " . $conn->error);
        }

        $stmt_update->bind_param("ssssissii", $vehicleMake, $vehicleModel, $vehicleBodytype, $fuelType, $mileage, $location, $year, $numDoors, $car_id);
        if ($stmt_update->execute()) {
            echo "Car details updated successfully.";
            $row['vehicle_make'] = $vehicleMake;
            $row['vehicle_model'] = $vehicleModel;
            $row['vehicle_bodytype'] = $vehicleBodytype;
            $row['fuel_type'] = $fuelType;
            $row['mileage'] = $mileage;
            $row['location'] = $location;
            $row['year'] = $year;
            $row['num_doors'] = $numDoors;
        } else {
            echo "Error updating record: " . $stmt_update->error;
        }
    } elseif (isset($_POST['delete']) && $row['user_id'] == $user_id) {
        $sql_delete = "DELETE FROM vehicle_details WHERE vehicle_id=?";
        $stmt_delete = $conn->prepare($sql_delete);
        if ($stmt_delete === false) {
            die("Error preparing the delete statement: " . $conn->error);
        }

        $stmt_delete->bind_param("i", $car_id);
        if ($stmt_delete->execute()) {
            echo "Car deleted successfully.";
            header("Location: index.php"); // Redirect after deletion
            exit();
        } else {
            echo "Error deleting record: " . $stmt_delete->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Summary and Edit</title>
    <link rel="stylesheet" href="../CSS/car_summary.css">

</head>
<header>
    <img src="data:image/png;base64,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", alt="Image not found", width="120", height="120">
    <h1>RentMyCar.IO</h1>
    <h2 style="display: inline-block;">Rent a car, anytime, anywhere</h2>
    <?php if (isset($_SESSION['user'])) : ?>
        <img style="position: absolute; top: 20px; right: 20px;  width: 180px; height: 180px" src='<?php echo htmlspecialchars($_SESSION['user'][15]); ?>'>
        <br>
        <button type="button" style="display: inline-block; float: right;" onclick="location.href='../php/logout.php'">Logout</button>
        <p style="display: inline-block; float: right;">Welcome <strong><?php echo htmlspecialchars($_SESSION['user'][1]); ?></strong></p>
    
    <?php else: ?>
        <!-- Login Form -->
            <form name="login" action="../PHP/login.php" onsubmit="return login_verification();" method="post">
                <label for="txtUserName">Username:</label>
                <input type="text" id="txtUserName" name="txtUserName" required><br><br>
                <label for="txtPWD">Password:</label>
                <input type="password" id="txtPWD" name="txtPWD" required><br><br>
                <input type="submit" value="Submit">
                <button type="button" onclick="location.href='registration.html'">Register</button>
            </form>
    <script src="../JavaScript/login.js"></script>
    <?php endif; ?>

      <br>

      <button type="Home" onclick="location.href='index.php'">Home</button>
      <button type="About" onclick="location.href='about.php'">About</button>
      <button type="Register_car" onclick="location.href='new_car.php'">New Car</button>
      <button type="View_cars" onclick="location.href='all_cars.php'">All Cars</button>
      
</header>
<body>
    <h1>Car Summary</h1>
    <p><strong>Make:</strong> <?php echo htmlspecialchars($row['vehicle_make']); ?></p>
    <p><strong>Model:</strong> <?php echo htmlspecialchars($row['vehicle_model']); ?></p>
    <p><strong>Bodytype:</strong> <?php echo htmlspecialchars($row['vehicle_bodytype']); ?></p>
    <p><strong>Fuel Type:</strong> <?php echo htmlspecialchars($row['fuel_type']); ?></p>
    <p><strong>Mileage:</strong> <?php echo htmlspecialchars($row['mileage']); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
    <p><strong>Year:</strong> <?php echo htmlspecialchars($row['year']); ?></p>
    <p><strong>Number of Doors:</strong> <?php echo htmlspecialchars($row['num_doors']); ?></p>

    
    <?php
    $image_urls_array = explode(',', $row["image_url"]);
        echo "<div id='Gallery1' class='gallery-container'>";
        foreach ($image_urls_array as $index => $image_url) {
        $active_class = $index === 0 ? 'active' : '';
        echo "<img src='" . $image_url . "' class='" . $active_class . "'>";
        echo "<a class='arrow left' onclick='changeImage(-1, \"Gallery1\")'>&#10094;</a>";
        echo "<a class='arrow right' onclick='changeImage(1, \"Gallery1\")'>&#10095;</a>";
        }
        echo"</div>";
        ?>
        <script>
        function changeImage(direction, Gallery1) {
            var gallery = document.getElementById(Gallery1);
            var images = gallery.getElementsByTagName('img');
            var activeIndex = -1;
    
            for (var i = 0; i < images.length; i++) {
                if (images[i].classList.contains('active')) {
                    activeIndex = i;
                    images[i].classList.remove('active');
                    break;
                }
            }
    
            if (activeIndex !== -1) {
                var newIndex = (activeIndex + direction + images.length) % images.length;
                images[newIndex].classList.add('active');
            }
        }
        </script>

    <?php if (isset($_SESSION['user']) && $row['user_id'] == $user_id): ?>
    
    <h2 style="position:relative;top:-190px;left:0px;">Edit Car Details</h2>
    <div id="Details" class ="Details-container">
    <form method="post">
        <label for="vehicle_make">Vehicle Make:</label>
        <input type="text" id="vehicle_make" name="vehicle_make" value="<?php echo htmlspecialchars($row['vehicle_make']); ?>" required><br>

        <label for="vehicle_model">Vehicle Model:</label>
        <input type="text" id="vehicle_model" name="vehicle_model" value="<?php echo htmlspecialchars($row['vehicle_model']); ?>" required><br>

        <label for="vehicle_bodytype">Vehicle Bodytype:</label>
        <input type="text" id="vehicle_bodytype" name="vehicle_bodytype" value="<?php echo htmlspecialchars($row['vehicle_bodytype']); ?>" required><br>

        <!-- <p><strong>Fuel Type:</strong> <?php echo htmlspecialchars($row['fuel_type']); ?></p> -->

        <label for="fuelType">Fuel Type:</label>
        <select id="fuelType" name="fuelType" required>
            <option value="Petrol" <?php if($row['fuel_type'] == 'Petrol') echo 'selected'; ?>>Petrol</option>
            <option value="Diesel" <?php if($row['fuel_type'] == 'Diesel') echo 'selected'; ?>>Diesel</option>
        </select><br><br>

        
        <label for="mileage">Mileage:</label>
        <input type="number" id="mileage" name="mileage" value="<?php echo htmlspecialchars($row['mileage']); ?>" required><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" required><br>

        <label for="year">Year:</label>
        <input type="number" id="year" min="1970" max="2024" name="year" value="<?php echo htmlspecialchars($row['year']); ?>" required><br>

        <!-- <input type="number" id="num_doors" name="num_doors" value="<?php echo htmlspecialchars($row['num_doors']); ?>" required><br> -->
        <label for="num_doors">Number of Doors:</label>
        <select id="num_doors" name="num_doors" required>
            <option value="3" <?php if($row['num_doors'] == '3') echo 'selected'; ?>>3</option>
            <option value="5" <?php if($row['num_doors'] == '5') echo 'selected'; ?>>5</option>
        </select><br><br>

        <input type="submit" name="update" value="Update Car Details">
        <input type="submit" name="delete" value="Delete Car">
    </form>
    </div>
    <?php endif; ?>
</body>
</html>
