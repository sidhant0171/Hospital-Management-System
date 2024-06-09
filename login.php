<?php
$showOTPForm = false;
$errorMessage = '';
$successMessage = '';
$enteredPhone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('connection.php'); 
    

    if (isset($_POST['phone'])) {
        $enteredPhone = htmlspecialchars($_POST['phone']);

        if (!preg_match("/^\+?[0-9]{10}$/", $enteredPhone)) {
            $errorMessage = "Invalid phone number format. Entered: " . htmlspecialchars($enteredPhone);
        } else {
            $stmt = $conn->prepare("SELECT Pid FROM patients WHERE Pphone = ?");
            $stmt->bind_param("s", $enteredPhone);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $otpCode = rand(100000, 999999);
                
                date_default_timezone_set('Asia/Kolkata');
                $expireTime = date('Y-m-d H:i:s', strtotime('+5 seconds'));

                echo "Generated OTP: " . $otpCode . "<br>";
                echo "Expiration Time (IST): " . $expireTime . "<br>";

                $insertStmt = $conn->prepare("INSERT INTO otps (Pphone, CODE, expire) VALUES (?, ?, ?)");
                $insertStmt->bind_param("sis", $enteredPhone, $otpCode, $expireTime);
                $insertStmt->execute();
                $insertStmt->close();

                $showOTPForm = true;
                $successMessage = "OTP sent successfully! Please enter the OTP below.";
            } else {
                $errorMessage = "Phone number not found in the database. Please register first.";
            }

            $stmt->close();
        }
    } elseif (isset($_POST['otp'])) {
        $enteredOTP = htmlspecialchars($_POST['otp']);

        $verifyStmt = $conn->prepare("SELECT code, expire FROM otps WHERE code = ?");
        $verifyStmt->bind_param("i", $enteredOTP);
        $verifyStmt->execute();
        $verifyStmt->store_result();

        if ($verifyStmt->num_rows > 0) {
            $verifyStmt->bind_result($otpCode, $expireTime);
            $verifyStmt->fetch();          

            date_default_timezone_set('Asia/Kolkata');
            $currentTime = date('Y-m-d H:i:s');

            if ($currentTime <= $expireTime) {
                $successMessage = "OTP verified successfully!";
                header("location: department.php");
            } else {
                $errorMessage = "OTP has expired.";
            }
        } else {
            $errorMessage = "Invalid OTP.";
        }

        $verifyStmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .welcome-message {
            margin-top: 50px;
            font-size: 24px;
        }
        .login-form {
            margin-top: 20px;
        }
        .otp-form {
            display: <?php echo $showOTPForm ? 'block' : 'none'; ?>;
        }
        .error-message {
            color: red;
        }
        .success-message {
            color: green;
        }
    </style>
</head> 
<body>
    <div class="welcome-message">
        <h2>Welcome to the Hospital Appointment System</h2>
    </div>

    <?php if (!empty($errorMessage)): ?>
        <div class="error-message"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <div class="login-form"> 
        <?php if (!$showOTPForm): ?>
            <h3>Login with Phone Number</h3>
            <form action="login.php" method="post">
                <label for="phone">Enter Phone Number:</label>
                <input type="text" id="phone" name="phone" required>
                <br>
                <br>
                <button type="submit" name="get_otp">Get OTP</button>
            </form>
        <?php else: ?>
            <h3>Enter OTP</h3>
            <div class="success-message"><?php echo $successMessage; ?></div>
            <form action="login.php" method="post">
                <label for="otp">Enter OTP sent to <?php echo $enteredPhone; ?>:</label>
                <input type="text" id="otp" name="otp" required> 
                <br>
                <br>
                <button type="submit" name="verify_otp">Verify OTP</button>
            </form>
        <?php endif; ?>
        <br>
        <div class="back-button">
            <a href="welcome.php"><button>back to the button</button></a>
        </div>
    </div>
</body>
</html>



