<?php
require_once('db.php');

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query the database to get the record with the specified ID
    $query = "SELECT * FROM violations WHERE ID = $id";
    $result = mysqli_query($con, $query);

    // Check if the record exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Record not found.";
        exit();
    }
} else {
    echo "ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit.css">
    <title>View Record</title>
</head>
<body>
    <div class="container">

        <h1>View Record</h1>
        <label for="id">Ticket Number:</label>
        <div id="id"><?php echo $row['ID']; ?></div>

        <label for="date">Date:</label>
        <div id="date"><?php echo $row['date']; ?></div>

        <label for="time">TIME:</label>
        <div id="time"><?php echo $row['time']; ?></div>

        <label for="location">Location:</label>
        <div id="location"><?php echo $row['location']; ?></div>

        <div class ="lname">
        <label for="last_name">Last Name:</label>
        <div id="last_name"><?php echo $row['last_name']; ?></div> </div>

        <div class ="fname">
        <label for="first_name">First Name:</label>
        <div id="first_name"><?php echo $row['first_name']; ?></div></div>

        <div class ="licnum">
        <label for="license_number">License Number:</label>
        <div id="license_number"><?php echo $row['license_number']; ?></div></div>

        <div class ="platenum">
        <label for="plate_number">Plate Number:</label>
        <div id="plate_number"><?php echo $row['plate_number']; ?></div> </div>

        <label for="violation_type">Violation Type:</label>
        <div id="violation_type"><?php echo $row['violation_type']; ?></div>

        <label for="fine">Fine:</label>
        <div id="fine"><?php echo $row['fine']; ?></div>
    </div>
</body>
</html>
