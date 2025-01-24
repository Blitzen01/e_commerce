<?php
    include '../../render/connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $selected_date = $_POST['date'];
        
        $query = "
            SELECT COUNT(*) AS total 
            FROM (
                SELECT date FROM booking
                UNION ALL
                SELECT date FROM booked
            ) AS combined
            WHERE scheduled_date = ?
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$selected_date]);
        $result = $stmt->fetch();

        echo json_encode(['total' => $result['total']]);
    }
?>
