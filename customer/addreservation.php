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
        $status = $_POST['status'];
        
        $insertQuery = "INSERT INTO reservation (username, idNo, contact, tables, date, time, noOfPeople, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param('ssssssis', $username, $idNo, $contact, $tables, $date, $time, $noOfPeople, $status);
        
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
        echo "No reservations found.";
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
    <link rel="stylesheet" href="style/style-addreservations.css">
    <style>
        html{
            overflow-y: scroll;
        }
    </style>
</head>
<body>
    <div class="reservation-container">
        <h2 class="reservation-text-topic">Add Reservation</h2>
        <form method="post" action="">
            <div class="reservation-mb-3">
                <label for="idNo" class="reservation-form-label">NIC Number</label><br>
                <input type="text" class="reservation-form-control" id="idNo" name="idNo" required>
            </div>  
            <div class="reservation-mb-3">
                <label for="contact" class="reservation-form-label">Contact Number</label><br>
                <input type="text" class="reservation-form-control" id="contact" name="contact" required>
            </div>
            <div class="reservation-mb-3">
                <label for="tables" class="reservation-form-label">Tables</label><br>
                <input type="text" class="reservation-form-control" id="tables" name="tables" required>
            </div>
            <div class="reservation-mb-3">
                <label for="date" class="reservation-form-label">Date</label><br>
                <input type="date" class="reservation-form-control" id="date" name="date" required>
            </div>
            <div class="reservation-mb-3">
                <label for="time" class="reservation-form-label">Time</label><br>
                <input type="time" class="reservation-form-control" id="time" name="time" required>
            </div>
            <div class="reservation-mb-3">
                <label for="noOfPeople" class="reservation-form-label">No Of People</label><br>
                <input type="number" class="reservation-form-control" id="noOfPeople" name="noOfPeople" required>
            </div>
            <div class="reservation-mb-3">
                <label for="status" class="reservation-form-label">Status</label><br>
                <input type="text" class="reservation-form-control" id="status" name="status" required>
            </div>
            <button type="submit" class="reservation-btn-add">Add</button>
        </form>
    </div>
</body>
</html>
