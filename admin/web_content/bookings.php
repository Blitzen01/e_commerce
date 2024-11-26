<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";
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
                <div class="col">
                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Bookings</h3>
                    <section class="my-2 px-4">
                        <table id="table_booking" class="table table-sm nowrap table-striped compact table-hover" >
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
                                    $sql = "SELECT * FROM booking";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <button class="bg-success border-0 p-1 text-light mb-2">Accept</button>
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

                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Booked</h3>
                    <section class="my-2 px-4">
                        <table class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Action</td>
                                    <td>Name</td>
                                    <td>Contact Number</td>
                                    <td>Date</td>
                                    <td>Item</td>
                                    <td>Item Qty.</td>
                                    <td>Total Price</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><button class="bg-success border-0 p-1 text-light">Finish</button></td>
                                    <td>Example Name</td>
                                    <td>12345</td>
                                    <td>10/10/1010</td>
                                    <td>Laptop</td>
                                    <td>3</td>
                                    <td>&#x20B1; 123,123</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Transaction History</h3>
                    <section class="my-2 px-4">
                        <table class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Name</td>
                                    <td>Contact Number</td>
                                    <td>Booked Date</td>
                                    <td>Settlement Date</td>
                                    <td>Item</td>
                                    <td>Item Qty.</td>
                                    <td>Total Price</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Example Name</td>
                                    <td>12345</td>
                                    <td>10/10/1010</td>
                                    <td>10/10/1010</td>
                                    <td>CCTV</td>
                                    <td>3</td>
                                    <td>&#x20B1; 123,123</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </div>


        <script src="../../assets/script/admin_script.js"></script>

        <script>
        </script>
    </body>
</html>