<?php
include_once('../connection.php');
include_once('navbar.php');

// Function to get the count of rows in a table
function getCount($tableName) {
    global $conn;

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM $tableName");
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the result and return the count
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalCount = $row['count'];
        return $totalCount;
    } else {
        return 0; 
    }
}

// Get the counts from respective tables
$loginCount = getCount('login_tbl');
$orderCount = getCount('orders');
$reservationCount = getCount('reservation');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style-home.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

</body>
</html>
