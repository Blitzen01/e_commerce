<?php
    include '../../render/connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form data
        $package = $_POST['package'];
        $package_id = $_POST['package_id'];
        $package_name = $_POST['package_name'];
        $package_price = $_POST['package_price'];
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
        $stocks = $_POST['stocks'];
        $cpu_only = $_POST['cpu_only'];

        // Prepare the update query with direct variable insertion
        $sql = "UPDATE package SET 
                package = '$package', 
                package_name = '$package_name', 
                package_price = '$package_price', 
                processor = '$processor', 
                processor_price = '$processor_price', 
                ram = '$ram', 
                ram_price = '$ram_price', 
                ssd = '$ssd', 
                ssd_price = '$ssd_price', 
                hdd = '$hdd', 
                hdd_price = '$hdd_price', 
                monitor = '$monitor', 
                monitor_price = '$monitor_price', 
                display = '$display', 
                display_price = '$display_price', 
                psu = '$psu', 
                psu_price = '$psu_price', 
                keyboard_mouse = '$keyboard_mouse', 
                keyboard_mouse_price = '$keyboard_mouse_price', 
                avr = '$avr', 
                avr_price = '$avr_price', 
                speaker = '$speaker', 
                speaker_price = '$speaker_price', 
                stocks = '$stocks', 
                cpu_only = '$cpu_only'
                WHERE id = '$package_id'";

        // Execute the query
        $result = mysqli_query($conn, $sql);

        // Check if the query was successful
        if ($result) {
            // If successful, redirect to another page (e.g., inventory page)
            $redirectUrl = "../../admin/web_content/inventory.php";
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    }
?>
