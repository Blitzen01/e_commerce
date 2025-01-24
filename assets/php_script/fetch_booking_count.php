<?php

include '../../render/connection.php'; // Ensure this file sets up the `$conn` variable properly

// Get the date from the query parameter
if (isset($_GET['date'])) {
    $date = $_GET['date'];

    // Query to count the number of entries from both 'bookings' and 'booked' tables
    $query = "
        SELECT SUM(total_count) AS total
        FROM (
            SELECT COUNT(*) AS total_count FROM booking WHERE date = ?
            UNION ALL
            SELECT COUNT(*) AS total_count FROM booked WHERE date = ?
        ) combined";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $date, $date); // Bind the date parameter twice, once for each query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['total' => $row['total']]);
    } else {
        echo json_encode(['total' => 0]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No date provided.']);
}

$conn->close();
?>
