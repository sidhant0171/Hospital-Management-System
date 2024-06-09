<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .registration-form {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: auto;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;   
            box-
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        button {
            background-color: #4285f4;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #1c3aa9;
        }
    </style>
</head>
<body>
    <div class="registration-form">
        <h3>Patient Registration</h3>

        <?php
        
        include('connection.php');

    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $pphone = $_POST["pphone"];
            $dob = $_POST["dob"];
            $gender = $_POST["gender"];
            $pemail = $_POST["pemail"];
            $paddress = $_POST["paddress"];
            $pincode = $_POST["pincode"];
            $state = $_POST["state"];
            $city = $_POST["city"];
            $centre = $_POST["centre"];
            $random=random_int(100000, 999999);
$val=1;
++$val;
$num=$val;
$MRNO="HOS".$random."00".$num;


            
            $sql = "INSERT INTO patients (firstname, lastname, Pphone, dob, gender, Pemail, Paddress, pincode, state, city, centre,MRNO) 
                    VALUES ('$firstname', '$lastname', '$pphone', '$dob', '$gender', '$pemail', '$paddress', '$pincode', '$state', '$city', '$centre','$MRNO')";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Registration successful!</p>";
            } else {
                echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }
        }
        

    
        $conn->close();
        ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" required>

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" required>

            <label for="pphone">Phone Number:</label>
            <input type="text" name="pphone">

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob">

            <label for="gender">Gender:</label>
            <select name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="pemail">Email:</label>
            <input type="email" name="pemail">

            <label for="paddress">Address:</label>
            <input type="text" name="paddress">

            <label for="pincode">Pincode:</label>
            <input type="text" name="pincode">

            <label for="state">State:</label>
            <input type="text" name="state">

            <label for="city">City:</label>
            <input type="text" name="city">

            <label for="centre">Centre:</label>
            <select name="centre">
                <option value="Ambala">Ambala</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Delhi">Delhi</option>
            </select>

            <input type="submit" value="Register">
        </form>

               
        <a href="welcome.php"><button>Back to Home</button></a>
    </div>
</body>
</html>
 
