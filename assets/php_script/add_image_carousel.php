<?php
    include '../../render/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "../../assets/image/carousel/";
    $image = $_FILES['image'];
    $imageName = basename($image['name']);
    $targetFilePath = $targetDir . $imageName;

    // Check if image is uploaded successfully
    if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
        // Insert into database
        $sql = "INSERT INTO carousel (img_name) VALUES ('$imageName')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['success' => true, 'img_name' => $imageName, 'id' => mysqli_insert_id($conn)]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
