<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Department and centre </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .department-form {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Select Department and centre </h2> 

    <form id="departmentForm" action="doctors.php" method="post" class="department-form">
        <label for="departments">Select Departments:</label>
        <select id="departments" name="departments" required>
            <?php
            include('connection.php'); 
            

            $query = "SELECT Dname FROM departments";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['Dname'] . "'>" . $row['Dname'] . "</option>";
                }
            } else {
                echo "<option value='' disabled>No departments available</option>"; 
            }
            
            $conn->close();
            ?>


        </select>
        <input type="submit" value="View Doctors">
    </form>
    <br>
    <a href="login.php"><button>Back</button></a>
    <br>
    <br>
    <br>
    <br>
    <a href="patient_dashboard.php"><button>check appointments</button></a>
</body>
</html>
