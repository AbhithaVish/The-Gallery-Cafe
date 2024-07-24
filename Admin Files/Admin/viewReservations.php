<?php
include_once('../connection.php');
include_once('navbar.php');


$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

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

// Handle editing
if (isset($_POST['update'])) {
    $id = $_POST['reservation_id'];
    $status = $_POST['status'];
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
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
    exit();
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
            overflow: scroll;
        }
    </style>
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
                            <form action="" method="POST">
                                <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['id']); ?>">
                                <select name="status" class="form-control mb-2">
                                    <option value="pending" <?php if ($reservation['status'] === 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="approved" <?php if ($reservation['status'] === 'approved') echo 'selected'; ?>>Approved</option>
                                    <option value="canceled" <?php if ($reservation['status'] === 'canceled') echo 'selected'; ?>>Canceled</option>
                                </select>
                                <button type="submit" name="update" class="btn btn-primary">Update</button>
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
<?php
include_once('../connection.php');
include_once('navbar.php');


$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

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

// Handle editing
if (isset($_POST['update'])) {
    $id = $_POST['reservation_id'];
    $status = $_POST['status'];
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
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
    exit();
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
    <style>
        body {
            overflow: scroll;
        }
    </style>
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
                            <form action="" method="POST">
                                <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['id']); ?>">
                                <select name="status" class="form-control mb-2">
                                    <option value="pending" <?php if ($reservation['status'] === 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="approved" <?php if ($reservation['status'] === 'approved') echo 'selected'; ?>>Approved</option>
                                    <option value="canceled" <?php if ($reservation['status'] === 'canceled') echo 'selected'; ?>>Canceled</option>
                                </select>
                                <button type="submit" name="update" class="btn btn-primary">Update</button>
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
