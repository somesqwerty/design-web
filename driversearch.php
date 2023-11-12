<?php
require_once('db.php');

// Initialize the search query and user's license number
$searchQuery = '';
$license_number = '';

// Check if a search query is provided in the URL
if (isset($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($con, $_GET['search']);
}

// Check if the user is logged in and retrieve their license number (you need to implement user authentication)
// For example, you can store the user's license number in a session variable after login.
// Replace 'USER_LICENSE_NUMBER' with your actual session variable name.
session_start(); 
if (isset($_SESSION['license_number'])) {
    $license_number = mysqli_real_escape_string($con, $_SESSION['license_number']);
}

// Construct the SQL query based on the user's license number
$query = "SELECT * FROM violations WHERE 1=0"; // Initialize with a condition that is always false

if (!empty($license_number) && !empty($searchQuery)) {
    $query = "SELECT * FROM violations WHERE license_number = '$license_number' AND license_number LIKE '%$searchQuery%'";
} elseif (!empty($license_number)) {
    $query = "SELECT * FROM violations WHERE license_number = '$license_number'";
} elseif (!empty($searchQuery)) {
    $query = "SELECT * FROM violations WHERE license_number LIKE '%$searchQuery%'";
}

$result = mysqli_query($con, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="driversearch.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <header></header>
        <h1 class="txtone">MAY VIOLATION MAN GD KO BALA?</h1>
        <img class="logo" src="btaologo.png">
    
        <div class="searchgroup">
            <!-- Update the form to accept the user's license number -->
            <form method="GET">
                <input type="text" id="search" name="search" value="<?php echo $searchQuery; ?>" required>
                <h1 id="enterlic">ENTER YOUR LICENSE NUMBER</h1>
                <input type="submit" id="searchbut" value="Search">
            </form>
        </div>

        <div class="resultbox">
            <?php
            if ($result->num_rows > 0) {
                echo '<table>
                        <thead>
                            <tr>
                                <th>Ticket Number</th>
                                <th>Location of Violation</th>
                                <th>Date Caught</th>
                                <th>Time Caught</th>
                                <th>Last Name</th>
                                <th>Violation Type</th>
                                <th>Fine</th>
                            </tr>
                        </thead>
                        <tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . ($row["ID"] ?? "") . "</td>";
                    echo "<td>" . $row["location"] . "</td>";
                    echo "<td>" . ($row["date"] ? $row["date"] : "admin entry") . "</td>";
                    echo "<td>" . ($row["time"] ? $row["time"] : "admin entry") . "</td>";
                    echo "<td>" . $row["last_name"] . "</td>";
                    echo "<td>" . $row["violation_type"] . "</td>";
                    echo "<td>" . $row["fine"] . "</td>";
                    echo "</tr>";
                }

                echo '</tbody></table>';
            } elseif (!empty($searchQuery)) {
                echo '<h1>No Results</h1>';
            } else {
                echo '<h1>Enter your license number</h1>';
            }
            ?>
        </div>
    </div>

    <script>
        // JavaScript to clear the input box after searching
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("search");
            searchInput.value = ''; // Clear the input field
        });
    </script>
</body>
</html>
