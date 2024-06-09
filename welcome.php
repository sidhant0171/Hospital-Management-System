
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
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
        .login-button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .register-link {
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="welcome-message">
        <h2>Civil Hospital Appointment System</h2>
    </div>

    <div class="login-form">
        <h3>Patient Login</h3>
        <button onclick="location.href='login.php'">Login with Phone Number</button>
    </div>

    <div class="login-form">
        <h3>Doctor Login</h3>
        <button class="login-button" onclick="location.href='doctors_login.php'">Login as Doctor</button>
    </div>

    <div class="register-link">
        <p>New patient? <a href="registration.php">Click here to register</a></p>
    </div>
</body>
</html>
 