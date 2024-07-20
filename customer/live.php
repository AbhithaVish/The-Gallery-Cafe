<?php

include_once('../connection.php');
include_once('navbar.php');


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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-live.css">
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
                    </tr>
                    <?php
                    if ($resultTables->num_rows > 0) {
                        while($row = $resultTables->fetch_assoc()) {
                            $statusClass = $row["status"] === 'Occupied' ? 'occupied' : 'available'; //if the status is = to one then one class will be executed else two(Ternary Operator)
                            echo "<tr><td>" . $row["table_id"]. "</td><td class='" . $statusClass . "'>" . $row["status"]. "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No data available</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="table-container">
                <h2>Parking Availability</h2>
                <table>
                    <tr>
                        <th>Parking Spot ID</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    if ($resultParking->num_rows > 0) {
                        while($row = $resultParking->fetch_assoc()) {
                            $statusClass = $row["status"] === 'Occupied' ? 'occupied' : 'available';
                            echo "<tr><td>" . $row["parking_spot_id"]. "</td><td class='" . $statusClass . "'>" . $row["status"]. "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No data available</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
