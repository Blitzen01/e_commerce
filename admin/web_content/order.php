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
        <title>Admin: Orders</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">
        <link rel="icon" href="/e_commerce/assets/image/hfa_logo.png" type="image/png">

        <style>
            #downloadCsvButtonOrder, #downloadCsvButton {
                background-color:rgb(24, 180, 219); /* Blue */
                color: white;
                border-radius: 0.25rem;
            }
            #downloadExcelButtonOrder, #downloadExcelButton {
                background-color:rgb(42, 196, 78); /* Green */
                color: white;
                border-radius: 0.25rem;
            }
            #downloadPdfButtonOrder, #downloadPdfButton {
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
                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Order Place</h3>
                    <section class="my-2 px-4">
                        <table id="table_order_booking" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Action</td>
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
                                    $sql = "SELECT * FROM order_booking";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <button class="bg-success border-0 p-1 text-light" data-bs-toggle="modal" data-bs-target="#accept_order_<?php echo $row['id']; ?>">Accept</button>
                                                    <button class="bg-danger border-0 p-1 text-light" data-bs-toggle="modal" data-bs-target="#decline_order_<?php echo $row['id']; ?>">Decline</button>
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['contact_number']; ?></td>
                                                <td><?php echo $row['date']; ?></td>
                                                <td><?php echo $row['item']; ?></td>
                                                <td><?php echo $row['quantity']; ?></td>
                                                <td><?php echo $row['price']; ?></td>
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

                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Orders Accepted</h3>
                    <section class="my-2 px-4">
                    <table id="table_order_booked" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Action</td>
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
                                    $sql = "SELECT * FROM order_booked";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                        if($row['mop'] == "cod") {
                                                            ?>
                                                                <button class="bg-success border-0 p-1 text-light" data-bs-toggle="modal" data-bs-target="#finish_order_<?php echo $row['id']; ?>">Finish</button>
                                                            <?php
                                                        } else if($row['mop'] == "otc") {
                                                            
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['contact_number']; ?></td>
                                                <td><?php echo $row['date']; ?></td>
                                                <td><?php echo $row['item']; ?></td>
                                                <td><?php echo $row['quantity']; ?></td>
                                                <td><?php echo $row['price']; ?></td>
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

                    <!-- <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Orders Transaction History</h3>
                    <section class="my-2 px-4">
                    <table id="table_order_transaction_history" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Address</td>
                                    <td>Contact Number</td>
                                    <td>Date</td>
                                    <td>Item Name</td>
                                    <td>Item Qty.</td>
                                    <td>Total Price</td>
                                    <td>Mode of Payment</td>
                                    <td>Status</td>
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
                                                <td><?php echo $row['status']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </section> -->
                </div>
            </div>
        </div>


        <script src="../../assets/script/admin_script.js"></script>

        <script>
            $(document).ready(function () {
                var table_booking = $('#table_order_booking').DataTable({
                    scrollX: true,
                    autoWidth: false
                });

                var table_booked = $('#table_order_booked').DataTable({
                    scrollX: true,
                    autoWidth: false
                });

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
            });
        </script>
    </body>
</html>


<!-- modals -->

<!-- finish order modal -->
<?php
    $sql = "SELECT * FROM order_booked";
    $result = mysqli_query($conn, $sql);

    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
?>
            <!-- Modal -->
            <div class="modal fade" id="finish_order_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="finish_order" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="finish_order">Finish Order</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../../assets/php_script/finish_order.php" method="post">
                                <h3>Are you sure the order is finish?</h3>
                                <input type="hidden" name="order_id" id="order_id" value="<?php echo $row['id']; ?>">
                                <p><b>Name:</b> <?php echo $row['name']; ?></p>
                                <p><b>Email:</b> <?php echo $row['email']; ?></p>
                                <p><b>Address:</b> <?php echo $row['address']; ?></p>
                                <p><b>Contact_number:</b> <?php echo $row['contact_number']; ?></p>
                                <p><b>Date:</b> <?php echo $row['date']; ?></p>
                                <p><b>Item:</b> <?php echo $row['item']; ?></p>
                                <p><b>Quantity:</b> <?php echo $row['quantity']; ?></p>
                                <p><b>Price:</b> <?php echo $row['price']; ?></p>
                                <p><b>MOP:</b> <?php echo $row['mop']; ?></p>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Finish</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    }
?>
<!-- finish order modal -->

<!-- accept order -->
<?php
    $sql = "SELECT * FROM order_booking";
    $result = mysqli_query($conn, $sql);

    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
?>
            <!-- Modal -->
            <div class="modal fade" id="accept_order_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="accept_order_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="accept_order_label">Accept Order</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../../assets/php_script/accept_order.php" method="post">
                                <h3>Confirm order</h3>
                                <!-- Pass the order_id instead of name -->
                                <input type="hidden" name="order_id" id="order_id" value="<?php echo $row['id']; ?>">
                                <p><b>Name:</b> <?php echo $row['name']; ?></p>
                                <p><b>Email:</b> <?php echo $row['email']; ?></p>
                                <p><b>Address:</b> <?php echo $row['address']; ?></p>
                                <p><b>Contact_number:</b> <?php echo $row['contact_number']; ?></p>
                                <p><b>Date:</b> <?php echo $row['date']; ?></p>
                                <p><b>Item:</b> <?php echo $row['item']; ?></p>
                                <p><b>Quantity:</b> <?php echo $row['quantity']; ?></p>
                                <p><b>Price:</b> <?php echo $row['price']; ?></p>
                                <p><b>MOP:</b> <?php echo $row['mop']; ?></p>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="Submit" class="btn btn-success">Accept</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    }
?>
<!-- accept order -->

<!-- decline order -->
<?php
    $sql = "SELECT * FROM order_booking";
    $result = mysqli_query($conn, $sql);

    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
?>
            <!-- Modal -->
            <div class="modal fade" id="decline_order_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="decline_order_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="decline_order_label">Decline Order</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../../assets/php_script/decline_order.php" method="post">
                                <h3>Are you sure do you want to decline this order?</h3>
                                <input type="hidden" name="order_id" id="order_id" value="<?php echo $row['id']; ?>">
                                <p><b>Name:</b> <?php echo $row['name']; ?></p>
                                <p><b>Email:</b> <?php echo $row['email']; ?></p>
                                <p><b>Address:</b> <?php echo $row['address']; ?></p>
                                <p><b>Contact_number:</b> <?php echo $row['contact_number']; ?></p>
                                <p><b>Date:</b> <?php echo $row['date']; ?></p>
                                <p><b>Item:</b> <?php echo $row['item']; ?></p>
                                <p><b>Quantity:</b> <?php echo $row['quantity']; ?></p>
                                <p><b>Price:</b> <?php echo $row['price']; ?></p>
                                <p><b>MOP:</b> <?php echo $row['mop']; ?></p>
                                <div class="mb-3">
                                    <label for="reason">Reason</label>
                                    <input type="text" name="reason" id="reason" class="form-control" required placeholder="Please state your reason here.">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Decline</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
?>
<!-- decline order -->