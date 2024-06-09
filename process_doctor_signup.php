<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $speciality = $_POST['speciality'];
    $typeId = $_POST['type']; 
    $fee = $_POST['fee']; 
    $departmentId = $_POST['department']; 
    $centreId = $_POST['centre']; 
    $slotId = $_POST['slot']; 

    $sql = "INSERT INTO doctors (DOname, DOemail, speciality, typeId, fee, Did, Hid, SLOTid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiiiii", $name, $email, $speciality, $typeId, $fee, $departmentId, $centreId, $slotId);

    if ($stmt->execute()) {
        header("Location: doctors_login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error; 
    }
}
?>
