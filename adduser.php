<?php
    require_once('db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user input
        $lastName = $_POST["last_name"];
        $firstName = $_POST["first_name"];
        $licenseNumber = $_POST["license_number"];
        $plateNumber = $_POST["plate_number"];
        $location = $_POST["location"];
        $violationType = $_POST["violation_type"];
        $fine = $_POST["fine"];

        // Insert the new record into the database
        $query = "INSERT INTO violations (last_name, first_name, license_number, plate_number, location, violation_type, fine) 
                  VALUES ('$lastName', '$firstName', '$licenseNumber', '$plateNumber', '$location', '$violationType', '$fine')";

        if (mysqli_query($con, $query)) {
            // Close the modal after successful addition
            echo '<script>window.parent.closeModal();</script>';
        } else {
            echo "Error adding record: " . mysqli_error($con);
        }
    }
?>
<!-- Rest of your HTML code -->

<!-- Rest of your HTML code -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adduser.css">
    <title>Add Driver</title>
</head>
<body>

<?php
// Get the current date and time
$currentDateTime = date("Y-m-d H:i:s"); // Format: YYYY-MM-DD HH:MM:SS
?>

    <div class="container">
        <div class="add-form">
            <form method="POST" action="adduser.php">
                <!-- Use table-like structure for form elements -->
                <div class="modal-table">
                    <div class="modal-row">
                        <div class="modal-cell">
                            <label for="last_name">Last Name:</label>
                        </div>
                        <div class="modal-cell">
                            <input type="text" id="lastnamebox" name="last_name" required>
                        </div>
                    </div>
                    <div class="modal-row">
                        <div class="modal-cell">
                            <label for="first_name">First Name:</label>
                        </div>
                        <div class="modal-cell">
                            <input type="text" id="firstnamebox" name="first_name" required>
                        </div>
                    </div>
                    <div class="modal-row">
                        <div class="modal-cell">
                            <label for="location">Location:</label>
                        </div>
                        <div class="modal-cell">
                            <input type="text" id="locationbox" name="location" required>
                        </div>
                    </div>
                    <div class="modal-row">
                        <div class="modal-cell">
                            <label for="license_number">License Number:</label>
                        </div>
                        <div class="modal-cell">
                            <input type="text" id="licensenumberbox" name="license_number" required>
                        </div>
                    </div>
                    <div class="modal-row">
                        <div class="modal-cell">
                            <label for="plate_number">Plate Number:</label>
                        </div>
                        <div class="modal-cell">
                            <input type="text" id="platenumberbox" name="plate_number" required>
                        </div>
                    </div>
               
                    <div class="modal-row">

                    <div class = "groupvio">
                    <div class="modal-row">
                        <div class="modal-cell">
                            <label for="violation_typetxt">Violation Type:</label>
                        </div>
                        <div class="modal-cell">
                            <select id="violation_type" name="violation_type" required onchange="calculateFine()">
                                <option value="Illegal Parking">Illegal Parking</option>
                                <option value="Reckless Driving">Reckless Driving</option>
                                <option value="Truck Ban">Truck Ban</option>
                                <option value="Overloading">Overloading</option>
                            </select>
                        </div>
                    </div>
        
                    <div class="modal-row">
                        <div class="modal-cell">
                            <label for="finetxt">Fine:</label>
                        </div>
                        <div class="modal-cell">
                            <input type="text" id="fine" name="fine" readonly required>
                        </div>
                    </div>
                </div>
                <input type="submit" id="subbtn" value="Add Driver">
            </form>
        </div>
    </div>

    <script>
        function calculateFine() {
            var violationType = document.getElementById("violation_type").value;
            var fineInput = document.getElementById("fine");

            switch (violationType) {
                case "Illegal Parking":
                    fineInput.value = "300 pesos";
                    break;
                case "Reckless Driving":
                    fineInput.value = "500 pesos";
                    break;
                case "Truck Ban":
                    fineInput.value = "800 pesos";
                    break;
                case "Overloading":
                    fineInput.value = "250 pesos";
                    break;
                default:
                    fineInput.value = "";
                    break;
            }
        }
    </script>

                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
