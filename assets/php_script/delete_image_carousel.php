<?php
    include '../../render/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    // Get the image filename from the database
    $sql = "SELECT img_name FROM carousel WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $imgName = $row['img_name'];

        // Delete image from directory
        $filePath = "../../assets/image/carousel/" . $imgName;
        if (unlink($filePath)) {
            // Remove image entry from the database
            $deleteSql = "DELETE FROM carousel WHERE id = $id";
            if (mysqli_query($conn, $deleteSql)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
?>
