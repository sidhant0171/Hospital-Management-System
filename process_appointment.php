<?php
if (isset($_POST['submit_appointment'])) {
  $doctorId = $_POST['doctor_id'];
  $appointmentDate = $_POST['appointment_date'];
  $appointmentTime = $_POST['appointment_time'];  
  $patientId = $_POST['patientId'];   

  
  include('connection.php');   

  $query = "INSERT INTO appointments (Did, SLOTid, Pid, Adate) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("iiss", $doctorId, $appointmentTime, $patientId, $appointmentDate);

  if ($stmt->execute()) {
    echo "<p>Appointment booked successfully.</p>";  
  } else {
    echo "<p>Error booking the appointment.</p>";
  }   

  $stmt->close();
  $conn->close();

} else {
  echo "<p>Invalid request. Please submit the appointment form.</p>";
}

header("Location: patient_dashboard.php");
exit();
?>


