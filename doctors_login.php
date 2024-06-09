<?php
include("connection.php");

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $doctor_name = $_POST["doctor_name"];
    $doctor_email = $_POST["doctor_email"];

    
    $sql = "SELECT * FROM doctors WHERE DOname = ? AND DOemail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $doctor_name, $doctor_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        header("Location: dashboard.php?doctor_name=$doctor_name");
        exit();
    } else {
        
        $error_message = "Invalid doctor name or email. Please try again."; 
    }

    $stmt->close();      
}      

$conn->close();
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login</title>
</head>
<body>
    <div>
        <h2>Doctor Login</h2>
        <form method="post" action="">
            <label for="doctor_name">Doctor Name:</label>
            <input type="text" id="doctor_name" name="doctor_name" required>
            
            <label for="doctor_email">Doctor Email:</label>
            <input type="email" id="doctor_email" name="doctor_email" required>
            
            <button type="submit">Login</button>
            <br>
            <br>
            <a href="doctor_signup.php"><button type="button">New Doctor?</button></a>
            <br>
            <br>
        </form>
        <?php if ($error_message) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?>
        <a href="welcome.php"><button>Back to Welcome</button></a>
    </div>
</body>
</html>
 