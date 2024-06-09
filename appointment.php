<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
if (isset($_POST['doctor_id'])) {
    $doctorId = $_POST['doctor_id'];

    include('connection.php');

   

    $query = "SELECT * FROM slots ";

    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<h3>Select a Time Slot</h3>";
            echo "<form action='process_appointment.php' method='post'>";
            echo "<input type='hidden' name='doctor_id' value='" . htmlspecialchars($doctorId) . "'>";

            echo "<label for='appointment_date'>Select Date:</label>";
            echo "<input type='date' name='appointment_date' required min='" . date("Y-m-d") . "'><br>";

            echo "<label for='appointment_time'>Select Time:</label>";
            echo "<select name='appointment_time' required>";

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row['SLOTid']) . "'>" . htmlspecialchars($row['slot_time']) . "</option>";
            }

            echo "</select>";   
            echo "<br><br>";

            echo "<button type='submit' name='submit_appointment'>Book Appointment</button>";
            echo "</form>";
            echo "<a href='doctors.php'><button>Back to Doctors</button></a>";
        } else {
            echo "<p>No available time slots for the selected doctor.</p>";
        }
    } else {
        echo "<p>Error fetching time slots. Please try again later.</p>";
    } 


    $conn->close();
} else {
    echo "<p>Invalid request. Please select a doctor first.</p>";
}
?>
</body>
</html>
