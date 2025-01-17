<?php
header('Content-Type: application/json');

include '../../render/connection.php';

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Query for bookings
$bookingsQuery = "
    SELECT type_of_booking, COUNT(*) AS booking_count
    FROM transaction_history
    WHERE WEEKOFYEAR(transaction_date) = WEEKOFYEAR(NOW())
    GROUP BY type_of_booking
    ORDER BY booking_count DESC
    LIMIT 5
";
$bookingsResult = $conn->query($bookingsQuery);
$bookings = [];
while ($row = $bookingsResult->fetch_assoc()) {
    $bookings[] = $row;
}

// Query for sales
$salesQuery = "
    SELECT item, SUM(quantity) AS total_sold
    FROM order_transaction_history
    WHERE WEEKOFYEAR(order_date) = WEEKOFYEAR(NOW())
    GROUP BY item
    ORDER BY total_sold DESC
    LIMIT 5
";
$salesResult = $conn->query($salesQuery);
$sales = [];
while ($row = $salesResult->fetch_assoc()) {
    $sales[] = $row;
}

// Return JSON data
echo json_encode(['bookings' => $bookings, 'sales' => $sales]);

$conn->close();
?>
