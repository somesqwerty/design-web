<?php
require_once('db.php');

// Initialize the search query
$searchQuery = '';

// Check if a search query is provided in the URL
if (isset($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($con, $_GET['search']);
}

// Construct the SQL query based on the search query
$query = "SELECT * FROM violations";

if (!empty($searchQuery)) {
    $query .= " WHERE license_number LIKE '%$searchQuery%'";
}

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <header>
            <img class="logo" src="btaologo.png">
            <nav>
                <ul>
                    <li><a href="home.php">HOME</a></li>
                    <li><a href="violation.php">VIOLATION</a></li>
                    <li><a href="registerenforcer.php" >REGISTER ENFORCER</a></li>
                </ul>
            </nav>
        </header>
        <a href="#" class="addbtn" id="openModalBtn">ADD DRIVER</a>
        <script>
            // Get the modal and buttons
            var modal = document.createElement('div');
            modal.className = 'modal';
            document.body.appendChild(modal);

            var openModalBtn = document.getElementById("openModalBtn");
            openModalBtn.onclick = function () {
                modal.style.display = "block";
                // Load the adduser.php content into the modal
                modal.innerHTML = `<div class="adduser-modal-content">
                <span class="close" onclick="closeModal()" onmouseover="this.style.backgroundColor='#8b1e06'" onmouseout="this.style.backgroundColor='transparent'">EXIT</span>
                             <iframe src="adduser.php" frameborder="0" width="100%" height="100%"></iframe>
                          </div>`;

                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.style.display = "none";
                modal.innerHTML = ''; // Clear the modal content
                document.body.style.overflow = 'auto'; // Restore scrolling
                // Reload the current page to update the user list
                location.reload();
            }
        </script>
    <!-- EDIT MODAL /////////////////////////////////////////-->
<script>
    function openEditModal(id) {
        var modal = document.createElement('div');
        modal.className = 'modal';
        document.body.appendChild(modal);
        modal.style.display = 'block';
        modal.innerHTML = `<div class="edit-modal-content">
            <span class="close" onclick="closeModal()" onmouseover="this.style.backgroundColor='#8b1e06'" onmouseout="this.style.backgroundColor='transparent'">EXIT</span>
            <iframe src="edit.php?id=${id}" frameborder="0" width="100%" height="100%"></iframe>
        </div>`;

        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        var modal = document.querySelector('.modal');
        modal.style.display = 'none';
        modal.innerHTML = '';
        document.body.style.overflow = 'auto';
        location.reload();
    }
</script>


        <!-- TABLE -->
        <h1 class="violationtxt"> Driver Reports </h1>
        <div class="search">
            <form method="get">
                <input type="text" id="searchInput" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button id="searchbut">Search</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>TICKET NUMBER</th>
                    <th>DATE</th>
                    <th>TIME</th>
                    <th>LOCATION</th>
                    <th>LICENSE NUMBER</th>
                    <th>PLATE NUMBER</th>
                    <th>VIOLATION</th>
                    <th>FINE</th>
                    <th>SHOW DETAILS</th>
                    <th>EDIT </th>
                    <th>DELETE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . ($row["ID"] ?? "") . "</td>";
                        echo "<td>" . ($row["date"] ? $row["date"] : "admin entry") . "</td>";
                        echo "<td>" . ($row["time"] ? $row["time"] : "admin entry") . "</td>";
                        echo "<td>" . $row["location"] . "</td>";
                        echo "<td class='license-number'>" . $row["license_number"] . "</td>";
                        echo "<td>" . $row["plate_number"] . "</td>";
                        echo "<td>" . $row["violation_type"] . "</td>";
                        echo "<td>" . $row["fine"] . "</td>";
                        echo "<td><a href='#' onclick='openEditModal(" . $row['ID'] . ")'>Details</a></td>";
                        echo "<td><a href='view.php?id=" . $row["ID"] . "&search=" . urlencode($searchQuery) . "'>Edit</a></td>";
                        echo "<td><a href='delete.php?id=" . $row["ID"] . "&search=" . urlencode($searchQuery) . "'>Delete</a></td>";

                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="11">NO RECORDS FOUND</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
