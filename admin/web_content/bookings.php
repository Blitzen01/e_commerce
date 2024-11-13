<?php
    include "../../assets/cdn/cdn_links.php";
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
                                    <td>
                                        <button class="bg-success border-0 p-1 text-light">Accept</button>
                                        <button class="bg-danger border-0 p-1 text-light">Decline</button>
                                    </td>
                                    <td>Example Name</td>
                                    <td>12345</td>
                                    <td>10/10/1010</td>
                                    <td>Camera</td>
                                    <td>3</td>
                                    <td>&#x20B1; 123,123</td>
                                </tr>
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
    </body>
</html>