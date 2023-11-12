<!-- EDIT.PHP RESERVE-->

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

        // Check if the form is submitted to update the record
        if (isset($_POST['update'])) {
            // Retrieve the updated data from the form
            $updatedLastName = $_POST['last_name'];
            $updatedLastName = $_POST['last_name'];
            $updatedFirstName = $_POST['first_name'];
            $updatedLicenseNumber = $_POST['license_number'];
            $updatedPlateNumber = $_POST['plate_number'];
            $updatedViolationType = $_POST['violation_type'];
            $updatedFine = $_POST['fine'];

            // Update the record in the database
            $updateQuery = "UPDATE violations SET
                last_name = '$updatedLastName',
                first_name = '$updatedFirstName',
                license_number = '$updatedLicenseNumber',
                plate_number = '$updatedPlateNumber',
                violation_type = '$updatedViolationType',
                fine = '$updatedFine'
                WHERE ID = $id";

            if (mysqli_query($con, $updateQuery)) {
                echo "Record updated successfully.";
                
                // Close the modal and reload the parent page (violation.php)
                echo '<script>
                    window.parent.closeModal(); // Close the modal
                    window.parent.location.reload(); // Reload the parent page
                </script>';
                exit();
            } else {
                echo "Error updating record: " . mysqli_error($con);
            }
        }
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
    <link rel="stylesheet" href="details.css">
    <title>Edit Record</title>
</head>
<body>
    <div class="container">
        <h1>Edit Record</h1>
        <form method="POST" action="details.php?id=<?php echo $id; ?>">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>"><br>

            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>"><br>

            <label for="license_number">License Number:</label>
            <input type="text" name="license_number" value="<?php echo $row['license_number']; ?>"><br>

            <label for="plate_number">Plate Number:</label>
            <input type="text" name="plate_number" value="<?php echo $row['plate_number']; ?>"><br>

            <label for="violation_type">Violation Type:</label>
            <input type="text" name="violation_type" value="<?php echo $row['violation_type']; ?>"><br>

            <label for="fine">Fine:</label>
            <input type="text" name="fine" value="<?php echo $row['fine']; ?>"><br>

            <input type="submit" name="update" value="Update">
        </form>
    </div>
</body>
</html>
