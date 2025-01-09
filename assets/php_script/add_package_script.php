<?php
    include '../../render/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Set the upload directory
    $upload_dir = '../../assets/image/package_image/';
    
    // Check if the file is uploaded
    if (isset($_FILES['package_image']) && $_FILES['package_image']['error'] == 0) {
        $file_name = $_FILES['package_image']['name'];
        $file_tmp = $_FILES['package_image']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        
        // Validate file extension (allowing only specific formats)
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($file_ext), $allowed_ext)) {
            // Create a unique file name to avoid overwrite
            $new_file_name = uniqid() . '.' . $file_ext;
            $file_path = $upload_dir . $new_file_name;
            
            // Move the uploaded file to the destination directory
            if (move_uploaded_file($file_tmp, $file_path)) {
                // File uploaded successfully, now insert data into database
                $package_image = $new_file_name; // Store image path
                $package = $_POST['package'];
                $package_price = $_POST['package_price'];
                $package_name = $_POST['package_name'];
                $processor = $_POST['processor'];
                $processor_price = $_POST['processor_price'];
                $ram = $_POST['ram'];
                $ram_price = $_POST['ram_price'];
                $ssd = $_POST['ssd'];
                $ssd_price = $_POST['ssd_price'];
                $hdd = $_POST['hdd'];
                $hdd_price = $_POST['hdd_price'];
                $monitor = $_POST['monitor'];
                $monitor_price = $_POST['monitor_price'];
                $display = $_POST['display'];
                $display_price = $_POST['display_price'];
                $psu = $_POST['psu'];
                $psu_price = $_POST['psu_price'];
                $keyboard_mouse = $_POST['keyboard_mouse'];
                $keyboard_mouse_price = $_POST['keyboard_mouse_price'];
                $avr = $_POST['avr'];
                $avr_price = $_POST['avr_price'];
                $speaker = $_POST['speaker'];
                $speaker_price = $_POST['speaker_price'];
                $cpu_only = $_POST['cpu_only'];
                $stocks = $_POST['stocks'];
                
                // Prepare SQL insert statement
                $sql = "INSERT INTO package (package_image, package, package_price, package_name, processor, processor_price, ram, ram_price, ssd, ssd_price, hdd, hdd_price, monitor, monitor_price, display, display_price, psu, psu_price, keyboard_mouse, keyboard_mouse_price, avr, avr_price, speaker, speaker_price, cpu_only, stocks) 
                        VALUES ('$package_image', '$package', '$package_price', '$package_name', '$processor', '$processor_price', '$ram', '$ram_price', '$ssd', '$ssd_price', '$hdd', '$hdd_price', '$monitor', '$monitor_price', '$display', '$display_price', '$psu', '$psu_price', '$keyboard_mouse', '$keyboard_mouse_price', '$avr', '$avr_price', '$speaker', '$speaker_price', '$cpu_only', '$stocks')";
                
                // Execute the query
                if (mysqli_query($conn, $sql)) {
                    // Redirect to the appropriate page after successful insertion
                    $redirectUrl = "../../admin/web_content/inventory.php";
                    echo '<script type="text/javascript">';
                    echo 'window.location.href = "' . $redirectUrl . '";';
                    echo '</script>';
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Failed to upload the image.";
            }
        } else {
            echo "Invalid file format. Only JPG, PNG, and GIF are allowed.";
        }
    } else {
        echo "No image uploaded or an error occurred.";
    }
}
?>
