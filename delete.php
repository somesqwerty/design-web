<?php
require_once('db.php');

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the search query parameter if it exists
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Query the database to get the record with the specified ID
    $query = "SELECT * FROM violations WHERE ID = $id";
    $result = mysqli_query($con, $query);

    // Check if the record exists
    if ($result->num_rows == 1) {
        // Delete the `violation_type` and `fine` columns for the record
        $updateQuery = "UPDATE violations SET violation_type = NULL, fine = NULL WHERE ID = $id";

        if (mysqli_query($con, $updateQuery)) {
            // Redirect back to violation.php with the search query
            if(isset($_GET['search'])) {
                $_SESSION['search_query'] = $_GET['search'];
                header("Location: violation.php?search=" . urlencode($_GET['search']));
            } else {
                header("Location: violation.php");
            }
            exit();
        } else {
            echo "Error deleting data: " . mysqli_error($con);
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
