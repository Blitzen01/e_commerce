<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";
    
    session_start();
    if (!isset($_SESSION['admin_email'])) {
        header("Location: ../index.php"); // Redirect to the index if not logged in
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: Transaction History</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">
        <link rel="icon" href="/e_commerce/assets/image/hfa_logo.png" type="image/png">

        <style>
            #downloadCsvButtonOrder, #downloadCsvButton, #downloadCsvButtonBooking, #downloadCsvButton {
                background-color:rgb(24, 180, 219); /* Blue */
                color: white;
                border-radius: 0.25rem;
            }
            #downloadExcelButtonOrder, #downloadExcelButton, #downloadExcelButtonBooking, #downloadExcelButton {
                background-color:rgb(42, 196, 78); /* Green */
                color: white;
                border-radius: 0.25rem;
            }
            #downloadPdfButtonOrder, #downloadPdfButton, #downloadPdfButtonBooking, #downloadPdfButton {
                background-color:rgb(207, 83, 96) !important; /* Red */
                color: white;
                border-radius: 0.25rem;
            }
        </style>
    </head>
    
    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col-lg-10">
                    <?php include "../../navigation/admin_header.php"; ?>
                    <h3 id="order" class="p-3 text-center"><i class="fa-solid fa-book"></i> Orders History</h3>
                    <section class="my-2 px-4">
                    <table id="table_order_transaction_history" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Status</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Address</td>
                                    <td>Contact Number</td>
                                    <td>Date</td>
                                    <td>Item Name</td>
                                    <td>Item Qty.</td>
                                    <td>Total Price</td>
                                    <td>Mode of Payment</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM order_transaction_history";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    $status = strtolower($row['status']); // Convert to lowercase for case-insensitive matching
                                                    $statusClass = "text-secondary"; // Default color (gray)

                                                    if (strpos($status, "finished") !== false) {
                                                        $statusClass = "text-success"; // Green for any "Finished" status
                                                    } elseif (strpos($status, "declined") !== false) {
                                                        $statusClass = "text-danger"; // Red for any "Declined" status
                                                    } elseif (strpos($status, "cancelled") !== false) {
                                                        $statusClass = "text-warning"; // Yellow/Orange for any "Cancelled" status
                                                    }

                                                    echo "<span class='$statusClass'>{$row['status']}</span>";
                                                    ?>
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['contact_number']; ?></td>
                                                <td><?php echo $row['transaction_date']; ?></td>
                                                <td><?php echo $row['item']; ?></td>
                                                <td><?php echo $row['quantity']; ?></td>
                                                <td><?php echo $row['total_amount']; ?></td>
                                                <td>
                                                    <?php 
                                                        if ($row['mop'] === 'otc') {
                                                            echo "Over the Counter (OTC)";
                                                        } else {
                                                            echo "Cash on Delivery (COD)";
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </section>

                    <h3 id="booking" class="p-3 text-center"><i class="fa-solid fa-book"></i> Booking History</h3>
                    <section class="my-2 px-4">
                        <table id="table_transaction_history" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Status</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Address</td>
                                    <td>Contact Number</td>
                                    <td>Booking Time Stamp</td>
                                    <td>Scheduled Date</td>
                                    <td>Scheduled Time</td>
                                    <td>Type of Booking</td>
                                    <td>Remarks</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM transaction_history";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $formattedDate = date("F j, Y", strtotime($row['transaction_date'])); // Month Day, Year
                                            $formattedTime = date("g:i A", strtotime($row['time']));  // 12-hour format with AM/PM
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    $status = strtolower($row['status']); // Convert to lowercase for case-insensitive matching
                                                    $statusClass = "text-secondary"; // Default color (gray)

                                                    if (strpos($status, "finished") !== false) {
                                                        $statusClass = "text-success"; // Green for any "Finished" status
                                                    } elseif (strpos($status, "declined") !== false) {
                                                        $statusClass = "text-danger"; // Red for any "Declined" status
                                                    } elseif (strpos($status, "cancelled") !== false) {
                                                        $statusClass = "text-warning"; // Yellow/Orange for any "Cancelled" status
                                                    }
                                                    
                                                    echo "<span class='$statusClass'>{$row['status']}</span>";
                                                    ?>
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['contact_number']; ?></td>
                                                <td><?php echo date('F j, Y g:ia', strtotime($row['booking_timestamp'])); ?></td>
                                                <td><?php echo $formattedDate; ?></td>
                                                <td><?php echo $formattedTime; ?></td>
                                                <td><?php echo $row['type_of_booking']; ?></td>
                                                <td><?php echo $row['remarks']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </div>

        <script src="../../assets/script/admin_script.js"></script>

        <script>
            $(document).ready(function () {
                var currentDate = new Date().toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }); // Format: January 1, 2025
                
                // Initialize DataTable for #table_order_transaction_history
                var table_booked = $('#table_order_transaction_history').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'csv',
                            title: `Order Transaction History - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadCsvButtonOrder'); // Set unique ID for CSV button
                                $(node).addClass('btn btn-primary rounded'); // Blue button for CSV
                            },
                        },
                        {
                            extend: 'excel',
                            title: `Order Transaction History - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadExcelButtonOrder'); // Set unique ID for Excel button
                                $(node).addClass('btn btn-success rounded'); // Green button for Excel
                            },
                        },
                        {
                            extend: 'pdf',
                            title: `Order Transaction History - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadPdfButtonOrder'); // Set unique ID for PDF button
                                $(node).addClass('btn btn-danger rounded'); // Red button for PDF
                            },
                            orientation: 'landscape', // Horizontal layout
                            pageSize: 'A4', // Page size
                            customize: function (doc) {
                                doc.styles.tableHeader = {
                                    bold: true,
                                    fontSize: 12,
                                    color: 'black',
                                    alignment: 'center'
                                };
                            }
                        },
                    ],
                    scrollX: true, // Enable horizontal scrolling
                    autoWidth: false // Prevent automatic width calculation
                });

                // Append buttons to the container
                table_booked.buttons().container()
                    .appendTo('#table_order_transaction_history_wrapper .col-md-6:eq(0)');

                    var table_transaction_history = $('#table_transaction_history').DataTable({
                    scrollX: true,
                    autoWidth: false,
                    dom: 'Bfrtip', // Required for buttons to display
                    buttons: [
                        {
                            extend: 'csv',
                            title: `Booking History - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadCsvButtonBooking'); // Set unique ID for CSV button
                                $(node).addClass('btn btn-primary rounded'); // Blue button for CSV
                            },
                        },
                        {
                            extend: 'excel',
                            title: `Booking History - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadExcelButtonBooking'); // Set unique ID for Excel button
                                $(node).addClass('btn btn-success rounded'); // Green button for Excel
                            },
                        },
                        {
                            extend: 'pdf',
                            title: `Booking History - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadPdfButtonBooking'); // Set unique ID for PDF button
                                $(node).addClass('btn btn-danger rounded'); // Red button for PDF
                            },
                            orientation: 'landscape', // Horizontal layout
                            pageSize: 'A4', // Page size
                            customize: function (doc) {
                                doc.styles.tableHeader = {
                                    bold: true,
                                    fontSize: 12,
                                    color: 'black',
                                    alignment: 'center'
                                };
                            }
                        }
                    ],
                    autoWidth: false, // Prevent automatic width calculation
                    initComplete: function () {
                        var tableWidth = this.api().table().node().offsetWidth;
                        var containerWidth = $(this.api().table().container()).parent().width();
                        if (tableWidth > containerWidth) {
                            this.api().settings()[0].oScroll.sX = '100%';
                            this.api().draw();
                        }
                    }
                });

                // Append buttons to the container
                table_transaction_history.buttons().container()
                    .appendTo('#table_transaction_history_wrapper .col-md-6:eq(0)');

            });
        </script>
    </body>
</html>