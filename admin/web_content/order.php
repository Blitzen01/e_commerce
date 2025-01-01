<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";
    
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: ../index.php"); // Redirect to the index if not logged in
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: Bookings</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">

    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col-lg-10">
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
                                                    <button class="bg-success border-0 p-1 text-light">Accept</button>
                                                    <button class="bg-danger border-0 p-1 text-light">Decline</button>
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
                                                    <button class="bg-success border-0 p-1 text-light">Accept</button>
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

                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Orders Transaction History</h3>
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
                                                <td>
                                                    <button class="bg-success border-0 p-1 text-light">Accept</button>
                                                    <button class="bg-danger border-0 p-1 text-light">Decline</button>
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
                                                <td><?php echo $row['status']; ?></td>
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
                var table_booking = $('#table_order_booking').DataTable({
                    scrollX: true
                });

                var table_booked = $('#table_order_booked').DataTable({
                    scrollX: true
                });

                var table_booked = $('#table_order_transaction_history').DataTable({
                    scrollX: true
                });
            });
        </script>
    </body>
</html>