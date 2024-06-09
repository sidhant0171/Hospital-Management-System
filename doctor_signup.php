<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Sign-up</title>
</head>
<body>
    <h2>Doctor Sign-up</h2>
    <form action="process_doctor_signup.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="speciality">Speciality:</label>
        <input type="text" id="speciality" name="speciality" required><br><br>

        <label for="type">Type:</label>
        <select id="type" name="type" required>
            <option value="">Select Type</option>
            <?php
            include("connection.php");
            $query = "SELECT type_id, type FROM Type";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['type_id'] . "'>" . $row['type'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="fees">Fees:</label>
        <input type="number" id="fees" name="fees" min="0" step="any" required><br><br>

        <label for="department">Department:</label>
        <select id="department" name="department" required>
            <option value="">Select Department</option>
            <?php
            $query = "SELECT Did, Dname FROM departments";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['Did'] . "'>" . $row['Dname'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="centre">Centre:</label>
        <select id="centre" name="centre" required>
            <option value="">Select Centre</option> 
            <?php
            $query = "SELECT Hid, centre FROM hospitals";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['Hid'] . "'>" . $row['centre'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <button type="submit">Sign Up</button>
    </form>
</body>
</html>
