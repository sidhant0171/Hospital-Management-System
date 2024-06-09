<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .department-form {
            margin-top: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 20px;
        }

        form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <h2>Doctors Information</h2>


    <form id="changeDepartmentForm" action="doctors.php" method="post" class="department-form">
        <label for="departments">Change Department:</label>
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
        <input type="submit" value="Change Department">
    </form>

    <?php
    
    if (isset($_POST['departments'])) {
    
        $selectedDepartment = $_POST['departments'];

        include('connection.php');
     
        $query = "SELECT * FROM doctors WHERE Did = (SELECT Did FROM departments WHERE Dname = ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("s", $selectedDepartment);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<h3>Doctors in $selectedDepartment Department</h3>";
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li><strong>Name:</strong> " . htmlspecialchars($row['DOname']) . "<br>";
                    echo "<strong>Fees:</strong> "   . htmlspecialchars($row['fee']) . "<br>";
                    echo "<strong>Email:</strong> " . htmlspecialchars($row['DOemail']) . "<br>";
                    echo "<strong>Speciality:</strong> " . htmlspecialchars($row['speciality']) . "<br><br>";

                    echo "<form action='appointment.php' method='post'>";
                    echo "<input type='hidden' name='doctor_id' value='" . htmlspecialchars($row['DOid']) . "'>";
                    echo "<input type='hidden' name='doctor_name' value='" . htmlspecialchars($row['DOname']) . "'>";
                    echo "<input type='submit' value='Book Appointment'>";
                    echo "</form>";

                    echo "</li><br>";
                }
                echo "</ul>";
            } else {
                echo "<p>No doctors found in $selectedDepartment Department.</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Query preparation failed.</p>";
        }

        $conn->close();
    } else {
        echo "<p>Please select a department first.</p>";
    }
    ?>

    <a href="department.php"><button>Back</button></a>
</body>
</html>
 