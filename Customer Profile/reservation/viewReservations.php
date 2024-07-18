<?php
session_start();

// Include database connection
include_once('../../connection.php'); // Adjust the path as necessary

// Fetch reservations from the database
$reservations = array(); // Initialize an array to hold reservations data

// Perform query to fetch reservations (MySQLi style)
$query = "SELECT * FROM reservations";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Fetch rows and store in $reservations array
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
} else {
    echo "No reservations found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="../nav bar - customer/style.css">
    <link rel="stylesheet" href="style-reservation.css">
</head>
<body>
    <?php include_once('../nav bar - customer/navbar.php'); ?>

    <div class="container">
        <h2>Reservations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>ID No</th>
                    <th>Contact</th>
                    <th>Tables</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>No Of People</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo $reservation['id']; ?></td>
                        <td><?php echo $reservation['username']; ?></td>
                        <td><?php echo $reservation['idNo']; ?></td>
                        <td><?php echo $reservation['contact']; ?></td>
                        <td><?php echo $reservation['tables']; ?></td>
                        <td><?php echo $reservation['date']; ?></td>
                        <td><?php echo $reservation['time']; ?></td>
                        <td><?php echo $reservation['noOfPeople']; ?></td>
                        <td><?php echo $reservation['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
