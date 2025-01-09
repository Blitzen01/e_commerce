<?php
    include '../../render/connection.php';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
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

        // Handle Image Upload
        if (isset($_FILES['package_image']) && $_FILES['package_image']['error'] == 0) {
            $image_tmp = $_FILES['package_image']['tmp_name'];
            $image_name = $_FILES['package_image']['name']; // Get only the file name with extension
            $image_size = $_FILES['package_image']['size'];
            $image_type = $_FILES['package_image']['type'];

            // Define upload directory and file path
            $upload_dir = '../../assets/image/package_image/';
            $image_path = $upload_dir . basename($image_name);

            // Check if file is an image (optional)
            if (getimagesize($image_tmp)) {
                // Move the uploaded image to the desired directory
                if (move_uploaded_file($image_tmp, $image_path)) {
                    // Insert package data into the database, including only the image file name
                    $sql = "INSERT INTO packages (package_image, package, package_price, package_name, processor, processor_price, ram, ram_price, ssd, ssd_price, hdd, hdd_price, monitor, monitor_price, display, display_price, psu, psu_price, keyboard_mouse, keyboard_mouse_price, avr, avr_price, speaker, speaker_price, cpu_only, stocks) 
                            VALUES ('$image_name', '$package', '$package_price', '$package_name', '$processor', '$processor_price', '$ram', '$ram_price', '$ssd', '$ssd_price', '$hdd', '$hdd_price', '$monitor', '$monitor_price', '$display', '$display_price', '$psu', '$psu_price', '$keyboard_mouse', '$keyboard_mouse_price', '$avr', '$avr_price', '$speaker', '$speaker_price', '$cpu_only', '$stocks')";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        // Redirect to the appropriate page after successful insertion
                        $redirectUrl = "../../admin/web_content/inventory.php";
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "' . $redirectUrl . '";';
                        echo '</script>';
                    } else {
                        // Error message if the query fails
                        echo "Error adding package: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error uploading image.";
                }
            } else {
                echo "The file is not a valid image.";
            }
        } else {
            echo "No image uploaded or error in file upload.";
        }

        // Close the database connection
        mysqli_close($conn);
    }
?>
