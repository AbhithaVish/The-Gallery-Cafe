<?php

include_once('../connection.php');
include_once('navbar.php');

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

$reservations = array();

$tableExistsQuery = "SHOW TABLES LIKE 'reservation'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows == 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idNo = $_POST['idNo'];
        $contact = $_POST['contact'];
        $tables = $_POST['tables'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $noOfPeople = $_POST['noOfPeople'];
        
        $insertQuery = "INSERT INTO reservation (username, idNo, contact, tables, date, time, noOfPeople) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param('ssssssi', $username, $idNo, $contact, $tables, $date, $time, $noOfPeople);
        
        if ($stmt->execute()) {
            echo "Reservation added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $query = "SELECT * FROM reservation WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }
    } else {
        // echo "No reservations found.";
    }
    $stmt->close();
} else {
    echo "Table 'reservations' does not exist.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style-addreservation.css">
</head>
<body>
    <div class="container-add">
        <h2>Add Reservation</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="idNo">ID Number</label>
                <input type="text" class="form-control" id="idNo" name="idNo" required placeholder="Enter your ID number">
            </div>
            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" class="form-control" id="contact" name="contact" required placeholder="Enter your contact number">
            </div>
            <div class="form-group">
                <label for="tables">Number of Tables</label>
                <input type="number" class="form-control" id="tables" name="tables" required placeholder="Enter number of tables">
            </div>
            <div class="form-group">
                <label for="date">Reservation Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Reservation Time</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>
            <div class="form-group">
                <label for="noOfPeople">Number of People</label>
                <input type="number" class="form-control" id="noOfPeople" name="noOfPeople" required placeholder="Enter number of people">
            </div>
            <button type="submit">Add Reservation</button>
        </form>
    </div>
</body>
</html>

