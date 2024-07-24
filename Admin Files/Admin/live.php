<?php
include_once('../connection.php');
include_once('navbar.php');

$editingTable = null;
$editingParking = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_table'])) {
        $table_id = $_POST['table_id'];
        $status = $_POST['status'];
        $sqlCheck = "SELECT 1 FROM `tables_availability` WHERE `table_id` = '$table_id' LIMIT 1";
        $result = $conn->query($sqlCheck);
        if ($result->num_rows == 0) {
            $sqlAddTable = "INSERT INTO `tables_availability` (`table_id`, `status`) VALUES ('$table_id', '$status')";
            $conn->query($sqlAddTable);
        } else {
            echo "Error: Table ID already exists.";
        }
    } elseif (isset($_POST['edit_table'])) {
        $table_id = $_POST['table_id'];
        $status = $_POST['status'];
        $sqlEditTable = "UPDATE `tables_availability` SET `status` = '$status' WHERE `table_id` = '$table_id'";
        $conn->query($sqlEditTable);
    } elseif (isset($_POST['delete_table'])) {
        $table_id = $_POST['table_id'];
        $sqlDeleteTable = "DELETE FROM `tables_availability` WHERE `table_id` = '$table_id'";
        $conn->query($sqlDeleteTable);
    } elseif (isset($_POST['add_parking'])) {
        $parking_spot_id = $_POST['parking_spot_id'];
        $status = $_POST['status'];
        $sqlCheck = "SELECT 1 FROM `parking_availability` WHERE `parking_spot_id` = '$parking_spot_id' LIMIT 1";
        $result = $conn->query($sqlCheck);
        if ($result->num_rows == 0) {
            $sqlAddParking = "INSERT INTO `parking_availability` (`parking_spot_id`, `status`) VALUES ('$parking_spot_id', '$status')";
            $conn->query($sqlAddParking);
        } else {
            echo "Error: Parking Spot ID already exists.";
        }
    } elseif (isset($_POST['edit_parking'])) {
        $parking_spot_id = $_POST['parking_spot_id'];
        $status = $_POST['status'];
        $sqlEditParking = "UPDATE `parking_availability` SET `status` = '$status' WHERE `parking_spot_id` = '$parking_spot_id'";
        $conn->query($sqlEditParking);
    } elseif (isset($_POST['delete_parking'])) {
        $parking_spot_id = $_POST['parking_spot_id'];
        $sqlDeleteParking = "DELETE FROM `parking_availability` WHERE `parking_spot_id` = '$parking_spot_id'";
        $conn->query($sqlDeleteParking);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['edit_table_id'])) {
        $table_id = $_GET['edit_table_id'];
        $sql = "SELECT * FROM `tables_availability` WHERE `table_id` = '$table_id' LIMIT 1";
        $result = $conn->query($sql);
        $editingTable = $result->fetch_assoc();
    } elseif (isset($_GET['edit_parking_id'])) {
        $parking_spot_id = $_GET['edit_parking_id'];
        $sql = "SELECT * FROM `parking_availability` WHERE `parking_spot_id` = '$parking_spot_id' LIMIT 1";
        $result = $conn->query($sql);
        $editingParking = $result->fetch_assoc();
    }
}

$sqlTables = "SELECT * FROM `tables_availability`";
$resultTables = $conn->query($sqlTables);

$sqlParking = "SELECT * FROM `parking_availability`";
$resultParking = $conn->query($sqlParking);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Data</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style-live.css">
</head>
<body>
    <div class="main-container">
        <div class="topic">
            <h1>Live Data</h1>
        </div>
        <div class="container">
            <div class="table-container">
                <h2>Tables Availability</h2>
                
                <table>
                    <tr>
                        <th>Table ID</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($resultTables->num_rows > 0) {
                        while($row = $resultTables->fetch_assoc()) {
                            $statusClass = $row["status"] === 'Occupied' ? 'occupied' : 'available';
                            echo "<tr><td>" . $row["table_id"]. "</td><td class='" . $statusClass . "'>" . $row["status"]. "</td>";
                            echo "<td><a href='?edit_table_id=" . $row["table_id"] . "'>Edit</a></td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No data available</td></tr>";
                    }
                    ?>
                </table>
                <form method="post">
                    <h3><?php echo $editingTable ? 'Edit Table' : 'Add Table'; ?></h3>
                    <input type="text" name="table_id" placeholder="Table ID" value="<?php echo $editingTable['table_id'] ?? ''; ?>" required <?php echo $editingTable ? 'readonly' : ''; ?>>
                    <select name="status" required>
                        <option value="Available" <?php echo (isset($editingTable['status']) && $editingTable['status'] === 'Available') ? 'selected' : ''; ?>>Available</option>
                        <option value="Occupied" <?php echo (isset($editingTable['status']) && $editingTable['status'] === 'Occupied') ? 'selected' : ''; ?>>Occupied</option>
                    </select>
                    <?php if ($editingTable): ?>
                        <button type="submit" name="edit_table" class="btn-class">Save</button>
                    <?php else: ?>
                        <button type="submit" name="add_table" class="btn-class">Add Table</button>
                    <?php endif; ?>
                </form>
                <form method="post">
                    <h3>Delete Table</h3>
                    <input type="text" name="table_id" placeholder="Table ID" required>
                    <button type="submit" name="delete_table" class="btn-delete">Delete Table</button>
                </form>
            </div>
            <div class="table-container">
                <h2>Parking Availability</h2>
                <table>
                    <tr>
                        <th>Parking Spot ID</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($resultParking->num_rows > 0) {
                        while($row = $resultParking->fetch_assoc()) {
                            $statusClass = $row["status"] === 'Occupied' ? 'occupied' : 'available';
                            echo "<tr><td>" . $row["parking_spot_id"]. "</td><td class='" . $statusClass . "'>" . $row["status"]. "</td>";
                            echo "<td><a href='?edit_parking_id=" . $row["parking_spot_id"] . "'>Edit</a></td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No data available</td></tr>";
                    }
                    ?>
                </table>
                <form method="post">
                    <h3><?php echo $editingParking ? 'Edit Parking Spot' : 'Add Parking Spot'; ?></h3>
                    <input type="text" name="parking_spot_id" placeholder="Parking Spot ID" value="<?php echo $editingParking['parking_spot_id'] ?? ''; ?>" required <?php echo $editingParking ? 'readonly' : ''; ?>>
                    <select name="status" required>
                        <option value="Available" <?php echo (isset($editingParking['status']) && $editingParking['status'] === 'Available') ? 'selected' : ''; ?>>Available</option>
                        <option value="Occupied" <?php echo (isset($editingParking['status']) && $editingParking['status'] === 'Occupied') ? 'selected' : ''; ?>>Occupied</option>
                    </select>
                    <?php if ($editingParking): ?>
                        <button type="submit" name="edit_parking" class="btn-class">Save</button>
                    <?php else: ?>
                        <button type="submit" name="add_parking" class="btn-class">Add Parking Spot</button>
                    <?php endif; ?>
                </form>
                <form method="post">
                    <h3>Delete Parking Spot</h3>
                    <input type="text" name="parking_spot_id" placeholder="Parking Spot ID" required>
                    <button type="submit" name="delete_parking" class="btn-delete">Delete Parking Spot</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
