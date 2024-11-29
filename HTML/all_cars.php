<?php
session_start();
if (!isset($_SESSION['user'])){
    $_SESSION["Page"] = "all_cars.php";
}
require '../PHP/conn.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register new vehicle</title>
    <meta charset="utf-8" />
    <meta name="author" content="Conor Judd"/>
    <meta name="description" content="All available cars" />
    <meta name="keywords" content="gallery, vehicle, cars ,HTML" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>    
    <link rel="stylesheet" href="../CSS/all_car.css">

    <title>View all cars</title>
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
    <h2>All cars</h2>
    <table>
    <?php
    // SQL query to retrieve all records from vehicle_details 
    $sql = "SELECT * FROM vehicle_details"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) { 
        $gallery_count = 0;
        echo "<tr>";
        while($row = $result->fetch_assoc()) { 
            $gallery_id = 'gallery_'.$gallery_count;
             
            ; // Open a new row every 5 columns 
            if ($gallery_count % 5 === 0 && $gallery_count !== 0) { 
                echo "</tr><tr>";}

            echo "<td>";
            // Split and output image URLs as a gallery
            $image_urls_array = explode(',', $row["image_url"]);
            echo "<a href='car_summary.php?vehicle_id=".$row['vehicle_id']."'>";
            echo "<div id='".$gallery_id."' class='gallery-container'>";
            foreach ($image_urls_array as $index => $image_url) {
                $active_class = $index === 0 ? 'active' : '';
                echo "<img src='" . $image_url . "' class='" . $active_class . "'>";
            }
            echo "<a class='arrow left' onclick='changeImage(-1, \"$gallery_id\")'>&#10094;</a>";
            echo "<a class='arrow right' onclick='changeImage(1, \"$gallery_id\")'>&#10095;</a>";
            echo "<div class='slideshow-text'>"; 
            echo "<h2>" . $row["vehicle_make"] . " " . $row["vehicle_model"] . "</h2>";
            echo "<h3>" . $row["year"] . "</h4>";
            echo "<h3>" . $row["mileage"] . " Miles" . "</h4>";
            echo "<h3>" . $row["location"] . "</h4>";
            echo "</div>"; 
            echo "</div>";
            echo "</td>";
    
            $gallery_count++;
        }
    } else {
        echo "<tr><td colspan='12'>No results found</td></tr>"; 
    }
    
    $conn->close(); 
    
    echo '</table>';
    ?>
        <script>
    function changeImage(direction, gallery_id) {
        var gallery = document.getElementById(gallery_id);
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


</body>