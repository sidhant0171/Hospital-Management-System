<?php
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History</title>
    <style>
        
        .finished {
            background-color: #aaffaa; 
        }

        
        .cancelled {
            background-color: #ffaaaa; 
        }
    </style>
</head>
<body>

<h2>Appointment History</h2>

<?php
$query = "SELECT a.Aid, a.Did, a.Pid, a.Adate, s.SLOTid, s.slot_time, a.status
          FROM appointments a
          INNER JOIN slots s ON a.SLOTid = s.SLOTid
          WHERE a.status IN ('cancelled', 'finished')"; 

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Appointment ID</th><th>Doctor ID</th><th>Patient ID</th><th>Appointment Date</th><th>Slot ID</th><th>Slot Time</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $statusClass = ($row['status'] == 'finished') ? 'finished' : 'cancelled'; 
        echo "<tr class='$statusClass'>"; 
        echo "<td>{$row['Aid']}</td>";
        echo "<td>{$row['Did']}</td>";
        echo "<td>{$row['Pid']}</td>";
        echo "<td>{$row['Adate']}</td>";
        echo "<td>{$row['SLOTid']}</td>";
        echo "<td>{$row['slot_time']}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No appointment history found.</p>";
}

$conn->close();
?>

<a href="welcome.php"><button>Back to the Dashboard</button></a>
</body>
</html>

