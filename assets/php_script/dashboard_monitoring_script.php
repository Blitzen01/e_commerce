<?php
    
    $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    $endOfWeek = date('Y-m-d', strtotime('sunday this week'));

    $weeklyTotalIncome = 0;
    $weeklyTotalOrder = 0;
    $weeklyTotalPendingOrder = 0;
    $weeklyTotalBooking = 0;
    $weeklyTotalPendingBooking = 0;

    // Query for the first table
    $weekly_transaction_history = "SELECT * FROM transaction_history WHERE DATE(transaction_date) BETWEEN '$startOfWeek' AND '$endOfWeek'";
    $weekly_transaction_history_result = mysqli_query($conn, $weekly_transaction_history);

    // Query for the second table
    $weekly_order_transaction_history = "SELECT * FROM order_transaction_history WHERE DATE(transaction_date) BETWEEN '$startOfWeek' AND '$endOfWeek'";
    $weekly_order_transaction_history_result = mysqli_query($conn, $weekly_order_transaction_history);

    if ($weekly_transaction_history_result && $weekly_order_transaction_history_result) {
        $allResults = [];
        
        // Fetch results from the first table
        while ($row1 = mysqli_fetch_assoc($weekly_transaction_history_result)) {
            $allResults[] = $row1;
            $weeklyTotalBooking++;
        }
        
        // Fetch results from the second table
        while ($row2 = mysqli_fetch_assoc($weekly_order_transaction_history_result)) {
            $allResults[] = $row2;
            $weeklyTotalOrder++;
        }

        // Calculate total income
        foreach ($allResults as $row) {
            $weeklyTotalIncome += $row['total_amount'];
        }
    }

    // Fixing the date query string for pending orders and bookings
    $weekly_pending_order = "SELECT * FROM order_booking WHERE DATE(date) BETWEEN '$startOfWeek' AND '$endOfWeek'";
    $weekly_pending_order_result = mysqli_query($conn, $weekly_pending_order);

    $weekly_pending_booking = "SELECT * FROM booked WHERE DATE(date) BETWEEN '$startOfWeek' AND '$endOfWeek'";
    $weekly_pending_booking_result = mysqli_query($conn, $weekly_pending_booking);

    if($weekly_pending_order_result && $weekly_pending_booking_result) {
        while($row1 = mysqli_fetch_assoc($weekly_pending_order_result)) {
            $weeklyTotalPendingOrder++;
        }
        while($row2 = mysqli_fetch_assoc($weekly_pending_booking_result)) {
            $weeklyTotalPendingBooking++;
        }
    }

    // ===================================================================================================

    $monthlyTotalBooking = 0;
    $monthlyTotalOrder = 0;
    $monthlyIncome = 0;
    $currentMonth = date('m');

    // Query for the first table
    $monthly_pending_booking = "SELECT * FROM transaction_history WHERE MONTH(transaction_date) = '$currentMonth'";
    $monthly_pending_booking_result = mysqli_query($conn, $monthly_pending_booking);

    // Query for the second table
    $monthly_pending_order = "SELECT * FROM order_transaction_history WHERE MONTH(transaction_date) = '$currentMonth'";
    $monthly_pending_order_result = mysqli_query($conn, $monthly_pending_order);

    if($monthly_pending_booking_result && $monthly_pending_order_result) {
        // Fetch results from the first table
        while ($row1 = mysqli_fetch_assoc($monthly_pending_booking_result)) {
            $monthlyTotalBooking++;
            $monthlyIncome += $row1['total_amount'];
        }
        
        // Fetch results from the second table
        while ($row2 = mysqli_fetch_assoc($monthly_pending_order_result)) {
            $monthlyTotalOrder++;
            $monthlyIncome += $row2['total_amount'];
        }
    }

    $yearlyTotalBooking = 0;
    $yearlyTotalOrder = 0;
    $yearlyIncome = 0;
    $currentYear = date('Y');

    // Query for the first table
    $yearly_booking_monitoring = "SELECT * FROM transaction_history WHERE YEAR(transaction_date) = '$currentYear'";
    $yearly_booking_monitoring_result = mysqli_query($conn, $yearly_booking_monitoring);

    // Query for the second table
    $yearly_order_monitoring = "SELECT * FROM order_transaction_history WHERE YEAR(transaction_date) = '$currentYear'";
    $yearly_order_monitoring_result = mysqli_query($conn, $yearly_order_monitoring);

    if($yearly_booking_monitoring_result && $yearly_order_monitoring_result) {
        // Fetch results from the first table
        while($row1 = mysqli_fetch_assoc($yearly_booking_monitoring_result)) {
            $yearlyTotalBooking++;
            $yearlyIncome += $row1['total_amount'];
        }
        // Fetch results from the second table
        while($row2 = mysqli_fetch_assoc($yearly_order_monitoring_result)) {
            $yearlyTotalOrder++;
            $yearlyIncome += $row2['total_amount'];
        }
    }
?>