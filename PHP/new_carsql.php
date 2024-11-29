<?php
require __DIR__ . '/conn.php';



session_start();

$allowed_image_types = ['jpeg', 'jpg', 'png', 'gif'];
$video_extensions = ["mp4", "avi", "mov", "wmv", "flv"];


// testing database connection
if ($conn->connect_error) {
    echo "Connection failed";
} else {
    $userid = ($_SESSION['user'][0]);
    $vehicleMake = $_POST['vehicle_make'];
    $vehicleModel = $_POST['vehicle_model'];
    $vehicleBodytype = $_POST['vehicle_bodytype'];
    $fuelType = $_POST['fuelType'];
    $mileage = $_POST['mileage'];
    $location = $_POST['location'];
    $year = $_POST['year'];
    $numDoors = $_POST['num_doors'];

    $image_urls = [];
    $video_urls = [];
    $target_dir = "../uploads/cars/".$userid."/".$vehicleMake."/".$year."/";

    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            die('Failed to create directories');
        }
    } else {
        echo 'Directory already exists.';
    }

    foreach ($_FILES["media"]["name"] as $key => $target_file) {
        $tempname = $_FILES['media']['tmp_name'][$key];
        $target_filepath = $target_dir . basename($target_file);

        if (move_uploaded_file($tempname, $target_filepath)) {
            echo "File ".basename($target_file)." uploaded successfully to" . $target_filepath . "<br>";

            
            $file_extension = pathinfo($target_filepath, PATHINFO_EXTENSION);
            if (in_array(strtolower($file_extension), $allowed_image_types)) {
                $image_urls[] = $target_filepath;
            } elseif (in_array(strtolower($file_extension), $video_extensions)) {
                $video_urls[] = $target_filepath;
            }

        } else {
            echo "Failed to upload file ".basename($target_file).".<br>";
        }
    }

    $image_url = implode(',', $image_urls);
    $video_url = implode(',', $video_urls);

    $sql_insert = "INSERT INTO vehicle_details (User_id, vehicle_make, vehicle_model, vehicle_bodytype, fuel_type, mileage, num_doors, location, year, image_url, video_url) VALUES ('$userid', '$vehicleMake', '$vehicleModel', '$vehicleBodytype', '$fuelType', '$mileage', '$numDoors', '$location', '$year', '$image_url', '$video_url');";

    $sql_existingcarcheck = "SELECT * FROM vehicle_details WHERE user_id ='$userid' AND vehicle_make = '$vehicleMake' AND vehicle_model = '$vehicleModel' AND mileage = '$mileage'";
    $sql_existingcarcheckresult = $conn->query($sql_existingcarcheck);

    if ($sql_existingcarcheckresult->num_rows >= 1) {
        echo "No value recorded, car already exists";
        
        header("location:javascript://history.go(-1)");
    } elseif ($conn->query($sql_insert) === TRUE) {
        if ($sql_existingcarcheckresult->num_rows >= 1) {
            echo '<script type="text/javascript">;';
            echo 'alert("Car added successfully.");';
            echo 'window.history.back();';
            echo '</script>';
            exit;
        }        
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
