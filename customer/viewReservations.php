<?php
// session_start();

include_once('../connection.php');
include_once('navbar.php');

$reservations = array(); 

// Check if the 'reservations' table exists
$tableExistsQuery = "SHOW TABLES LIKE 'reservation'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows == 1) {
    $query = "SELECT * FROM reservation";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }
    } else {
        echo "No reservations found.";
    }
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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-Vreservation.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Reservations</h2>
        <div class="row">
            <?php foreach ($reservations as $reservation): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Reservation ID: <?php echo htmlspecialchars($reservation['id']); ?></h5>
                            <p class="card-text"><strong>Username:</strong> <?php echo htmlspecialchars($reservation['username']); ?></p>
                            <p class="card-text"><strong>ID No:</strong> <?php echo htmlspecialchars($reservation['idNo']); ?></p>
                            <p class="card-text"><strong>Contact:</strong> <?php echo htmlspecialchars($reservation['contact']); ?></p>
                            <p class="card-text"><strong>Tables:</strong> <?php echo htmlspecialchars($reservation['tables']); ?></p>
                            <p class="card-text"><strong>Date:</strong> <?php echo htmlspecialchars($reservation['date']); ?></p>
                            <p class="card-text"><strong>Time:</strong> <?php echo htmlspecialchars($reservation['time']); ?></p>
                            <p class="card-text"><strong>No Of People:</strong> <?php echo htmlspecialchars($reservation['noOfPeople']); ?></p>
                            <p class="card-text"><strong>Status:</strong> <?php echo htmlspecialchars($reservation['status']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
