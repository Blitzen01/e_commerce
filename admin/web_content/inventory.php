<?php
    include "../../assets/cdn/cdn_links.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: Inventory</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">

    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col">
                    <h3 class="p-3 text-center"><i class="fa-solid fa-warehouse"></i> Inventory</h3>
                    <section class="my-2 px-4">
                        <h4 class="pt-3">Hikvision CCTV <button class="btn btn-info p-1">Add Product</button></h4>
                        <table class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Product Name</td>
                                    <td>Price</td>
                                    <td>Stocks</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Hikvision DS-2CE16D0T-EXIPF 2MP Outdoor Bullet</td>
                                    <td>680</td>
                                    <td>53</td>
                                    <td>
                                        <button class="bg-success border-0 text-light p-1">Update</button>
                                        <button class="bg-danger border-0 text-light p-1">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hikvision DS-2CE76D0T-EXIPF 2MP Dome Indoor</td>
                                    <td>650</td>
                                    <td>44</td>
                                    <td>
                                        <button class="bg-success border-0 text-light p-1">Update</button>
                                        <button class="bg-danger border-0 text-light p-1">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4 class="pt-3">Dahua and UNV <button class="btn btn-info p-1">Add Product</button></h4>
                        <table class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Product Name</td>
                                    <td>Price</td>
                                    <td>Stocks</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>DAHUA DH-HAC-B1A21N 2MP Bullet Outdoor</td>
                                    <td>680</td>
                                    <td>53</td>
                                    <td>
                                        <button class="bg-success border-0 text-light p-1">Update</button>
                                        <button class="bg-danger border-0 text-light p-1">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>DAHUA DH-HAC-HFW1200CN 2MP Bullet  Outdoor</td>
                                    <td>740</td>
                                    <td>44</td>
                                    <td>
                                        <button class="bg-success border-0 text-light p-1">Update</button>
                                        <button class="bg-danger border-0 text-light p-1">Delete</button>
                                    </td>
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