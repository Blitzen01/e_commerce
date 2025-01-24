<?php
    include '../../render/connection.php';

    // Retrieve JSON data from the request
    $input = json_decode(file_get_contents("php://input"), true);
    $itemIds = $input["item_ids"] ?? [];

    if (empty($itemIds)) {
        echo json_encode(["success" => false, "error" => "No items provided"]);
        exit;
    }

    try {
        // Create a parameterized SQL query to delete the items
        $placeholders = implode(',', array_fill(0, count($itemIds), '?'));
        $stmt = $conn->prepare("DELETE FROM product_cart WHERE id IN ($placeholders)");
        $stmt->bind_param(str_repeat('i', count($itemIds)), ...$itemIds);
        $stmt->execute();

        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
?>
