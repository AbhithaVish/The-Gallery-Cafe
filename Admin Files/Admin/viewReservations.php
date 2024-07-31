<?php
include_once('../connection.php');
include_once('navbar.php');

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Handle deletion
if (isset($_POST['delete'])) {
    $id = $_POST['reservation_id'];
    echo "Attempting to delete reservation ID: $id";

    $deleteQuery = "DELETE FROM reservation WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "Reservation deleted successfully.";
    } else {
        echo "Error deleting reservation: " . $stmt->error;
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
    exit();
}

// Handle status update
if (isset($_POST['update_status'])) {
    $id = $_POST['reservation_id'];
    $status = $_POST['new_status'];
    echo "Attempting to update reservation ID: $id with status: $status";

    $updateQuery = "UPDATE reservation SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('si', $status, $id);

    if ($stmt->execute()) {
        echo "Reservation updated successfully.";
    } else {
        echo "Error updating reservation: " . $stmt->error;
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit();
}

// Fetch reservations
$reservations = array();

$tableExistsQuery = "SHOW TABLES LIKE 'reservation'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows == 1) {
    $query = "SELECT * FROM reservation";
    $stmt = $conn->prepare($query);
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
    echo "Table 'reservation' does not exist.";
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
    <link rel="stylesheet" href="style/style-Vreservation.css">
    <style>
        body {
            margin-top: 50px;
            overflow-y: auto;
        }
        .container {
            max-height: 80vh; 
            
            padding: 20px;
        }
        .status-buttons form {
            display: inline-block;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
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
                            <div class="status-buttons">
                                <form action="" method="POST">
                                    <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['id']); ?>">
                                    <input type="hidden" name="new_status" value="pending">
                                    <button type="submit" name="update_status" class="btn btn-warning">Pending</button>
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['id']); ?>">
                                    <input type="hidden" name="new_status" value="approved">
                                    <button type="submit" name="update_status" class="btn btn-success">Approved</button>
                                </form>
                                <form action="" method="POST">
                                    <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['id']); ?>">
                                    <input type="hidden" name="new_status" value="canceled">
                                    <button type="submit" name="update_status" class="btn btn-danger">Canceled</button>
                                </form>
                            </div>
                            <form action="" method="POST" style="margin-top: 10px;">
                                <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['id']); ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
