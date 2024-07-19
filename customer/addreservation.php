<?php
// session_start();

include_once('../connection.php');
include_once('navbar.php');

// Get the logged-in username from session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Initialize the reservations array
$reservations = array();

// Check if the 'reservations' table exists
$tableExistsQuery = "SHOW TABLES LIKE 'reservation'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows == 1) {
    // Handle form submission for adding reservations
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

    // Modify query to filter reservations based on the logged-in username
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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-Vreservation.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Add Reservation</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="idNo" class="form-label">ID No</label>
                <input type="text" class="form-control" id="idNo" name="idNo" required>
            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
            </div>
            <div class="mb-3">
                <label for="tables" class="form-label">Tables</label>
                <input type="text" class="form-control" id="tables" name="tables" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Time</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>
            <div class="mb-3">
                <label for="noOfPeople" class="form-label">No Of People</label>
                <input type="number" class="form-control" id="noOfPeople" name="noOfPeople" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Reservation</button>
        </form>
        
        <h2 class="text-center mt-5">Your Reservations</h2>
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
