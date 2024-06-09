<?php
include('connection.php');


if (!isset($_GET['doctor_name'])) {
    header("Location: doctor_login.php");
    exit();
} 

$doctor_name = $_GET['doctor_name'];
                                 


if ($_SERVER["REQUEST_METHOD"] == "POST") {         


    
    if (isset($_POST['update'])) {
        $aid = $_POST['aid'];
        $newSlotId = $_POST['newSlotId'];
        $checkPatientQuery = "SELECT Pid FROM appointments WHERE Aid = $aid";
        $result = $conn->query($checkPatientQuery);    
        $row = $result->fetch_assoc(); 
        if ($row['Pid'] === NULL) {
            $updateQuery = "UPDATE appointments SET SLOTid = $newSlotId WHERE Aid = $aid";
            if ($conn->query($updateQuery) === TRUE) {
                echo "<p>Slot ID updated successfully</p>";
            } else {
                echo "Error updating slot ID: " . $conn->error;
            }
        } else {
            echo "<p>This appointment has already been assigned to a patient.</p>";
        }
    } 

    elseif (isset($_POST['finish'])) {
        $aid = $_POST['aid'];
        $updateQuery = "UPDATE appointments SET status = 'finished' WHERE Aid = $aid";
        if ($conn->query($updateQuery) === TRUE) {
            echo "<p>Appointment marked as finished successfully</p>";
        } else {
            echo "Error marking appointment as finished: " . $conn->error;
        }  
    } 
    
    elseif (isset($_POST['cancel'])) { 
        $aid = $_POST['aid'];                
        $updateQuery = "UPDATE appointments SET status = 'cancelled' WHERE Aid = $aid";
        if ($conn->query($updateQuery) === TRUE) {
            echo "<p>Appointment canceled successfully</p>";
        } else {
            echo "Error canceling appointment: " . $conn->error;
        }
    }
}


$query = "SELECT a.Aid, a.Did, a.Pid, a.Adate, s.SLOTid, s.slot_time, d.fee
          FROM appointments a
          INNER JOIN slots s ON a.SLOTid = s.SLOTid
          INNER JOIN doctors d ON a.Did = d.DOid
          WHERE a.status = 'pending' AND d.DOname = '$doctor_name'"; 


if (isset($_POST['selected_day'])) {
    $selected_day = $_POST['selected_day'];
    
    $query .= " AND DATE(a.Adate) = '$selected_day'";
}


$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointments</title>
</head>
<body>

<?php
if ($result->num_rows > 0) {
    echo "<h2>Pending Appointments</h2>";   
    echo "<table>";
    echo "<tr><th>Appointment ID</th><th>Doctor ID</th><th>Patient ID</th><th>Appointment Date</th><th>Slot</th><th>Doctor Fee</th><th>Action</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['Aid']}</td>";
        echo "<td>{$row['Did']}</td>";
        echo "<td>{$row['Pid']}</td>";
        echo "<td>{$row['Adate']}</td>";
        echo "<td>{$row['SLOTid']} - {$row['slot_time']}</td>";
        echo "<td>{$row['fee']}</td>";
        echo "<td>
                <form method='post' action=''>
                    <input type='hidden' name='aid' value='{$row['Aid']}'>
                    <label for='newSlotId'>New Slot:</label>
                    <select name='newSlotId' required>";
                    
        $availableSlotsQuery = "SELECT SLOTid, slot_time FROM slots";
        $availableSlotsResult = $conn->query($availableSlotsQuery);
        while ($slotRow = $availableSlotsResult->fetch_assoc()) {
            echo "<option value='{$slotRow['SLOTid']}'>{$slotRow['SLOTid']} - {$slotRow['slot_time']}</option>";
        }
        echo "</select>
              <input type='submit' name='update' value='Update'>
            </form>
          </td>";
        echo "<td>
                <form method='post' action=''>
                    <input type='hidden' name='aid' value='{$row['Aid']}'>
                    <input type='submit' name='finish' value='Finish Appointment'>
                </form>
              </td>";
        echo "<td>
                <form method='post' action=''>
                    <input type='hidden' name='aid' value='{$row['Aid']}'>
                    <input type='submit' name='cancel' value='Cancel Appointment'>
                </form>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<h2>No Pending Appointments</h2>";
}
?>


<form method="post" action="">
    <label for="selected_day">Select Day:</label>
    <input type="date" id="selected_day" name="selected_day" required>
    <input type="submit" value="Show Appointments">
</form>


<form action="history_appointment.php">
    <button type="submit">View Appointment History</button>   
</form>
<br>
<br>
<form action="welcome.php">
    <button type="submit">Back to the Dashboard</button>
</form>

</body>
</html>

<?php

$conn->close();
?>
