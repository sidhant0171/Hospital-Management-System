<?php
include('connection.php');

$query = "SELECT a.Aid, a.Did, CONCAT(p.firstname, ' ', p.lastname) AS patient_name, a.Adate, s.SLOTid, s.slot_time, d.fee
          FROM appointments a
          INNER JOIN slots s ON a.SLOTid = s.SLOTid
          INNER JOIN doctors d ON a.Did = d.DOid
          INNER JOIN patients p ON a.Pid = p.Pid";  

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Appointment ID</th><th>Doctor ID</th><th>Patient Name</th><th>Appointment Date</th><th>Slot ID</th><th>Slot Time</th><th>Doctor Fee</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>"; 
        echo "<td>{$row['Aid']}</td>";
        echo "<td>{$row['Did']}</td>";
        echo "<td>{$row['patient_name']}</td>";
        echo "<td>{$row['Adate']}</td>";
        echo "<td>{$row['SLOTid']}</td>";
        echo "<td>{$row['slot_time']}</td>";
        echo "<td>{$row['fee']}</td>"; 
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No appointments found.</p>";
}

$conn->close();
?>

<a href="department.php"><button>Back to Department</button></a>  
