<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";
    include "../../render/modals.php";
    
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
        <title>Admin: Inventory</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">

    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col-lg-10">
                    <h3 class="p-3 text-center"><i class="fa-solid fa-warehouse"></i> Inventory</h3>
                    <section id="package_section" class="my-2 px-4">
                        <h4 class="pt-3">Package List</h4>
                        <button class="btn p-1 mb-3 border border-1" data-bs-toggle="modal" data-bs-target="#add_package_modal">
                            <i class="fa-solid fa-plus"></i> Add Package
                        </button>
                        <table id="package_table" class="table nowrap table-strip compact table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Category</th>
                                    <th>Package Name</th>
                                    <th>Price</th>
                                    <th>Stocks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>Inter i3 14gen</td>
                                    <td>INTEL CORE i3-12100 12GEN PACKAGE</td>
                                    <td> ₱17,975.00</td>
                                    <td>12</td>
                                    <td>
                                        <button 
                                            class="bg-success border-0 text-light p-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#update_package_modal" 
                                            data-id="<?php echo $row['id']; ?>" 
                                            data-category="<?php echo $row['category']; ?>" 
                                            data-name="<?php echo $row['product_name']; ?>" 
                                            data-price="<?php echo $row['price']; ?>" 
                                            data-stocks="<?php echo $row['stocks']; ?>">
                                            Update
                                        </button>
                                        <button 
                                            class="bg-danger border-0 text-light p-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#delete_package_modal" 
                                            data-id="<?php echo $row['id']; ?>">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                    <section id="product_section" class="my-2 px-4">
                        <h4 class="pt-3">Product List</h4>
                        <button class="btn p-1 mb-3 border border-1" data-bs-toggle="modal" data-bs-target="#add_product_modal">
                            <i class="fa-solid fa-plus"></i> Add Product
                        </button>
                        <table id="product_table" class="table nowrap table-striped compact table-hover">
                            <thead>
                                <tr>
                                    <td>Category</td>
                                    <td>Product Name</td>
                                    <td>Price</td>
                                    <td>Stocks</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM products";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['category']; ?></td>
                                                <td><?php echo $row['product_name']; ?></td>
                                                <td><?php echo $row['price']; ?></td>
                                                <td><?php echo $row['stocks']; ?></td>
                                                <td>
                                                    <button 
                                                        class="bg-success border-0 text-light p-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#update_product_modal" 
                                                        data-id="<?php echo $row['id']; ?>" 
                                                        data-category="<?php echo $row['category']; ?>" 
                                                        data-name="<?php echo $row['product_name']; ?>" 
                                                        data-price="<?php echo $row['price']; ?>" 
                                                        data-stocks="<?php echo $row['stocks']; ?>">
                                                        Update
                                                    </button>
                                                    <button 
                                                        class="bg-danger border-0 text-light p-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#delete_product_modal" 
                                                        data-id="<?php echo $row['id']; ?>">
                                                        Delete
                                                    </button>
                                                </td>
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
            // script for product table
            $(document).ready(function () {
                var dataTableBorrowed = $('#product_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'csv',
                            text: 'CSV',
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadCsvButton'); // Set unique ID for CSV button
                            },
                            filename: 'HFA Price List',
                            exportOptions: {
                                columns: ':not(:last-child)' // Excludes the last column (Action column)
                            }
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadExcelButton'); // Set unique ID for Excel button
                            },
                            filename: 'HFA Price List',
                            exportOptions: {
                                columns: ':not(:last-child)' // Excludes the last column (Action column)
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadPdfButton'); // Set unique ID for PDF button
                            },
                            filename: 'HFA Price List',
                            exportOptions: {
                                columns: ':not(:last-child)' // Excludes the last column (Action column)
                            }
                        }
                    ]
                });
            });


            // script for updating product
            document.addEventListener('DOMContentLoaded', function() {
                var updateModal = document.getElementById('update_product_modal');
                updateModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget; // Button that triggered the modal
                    var productId = button.getAttribute('data-id');
                    var productCategory = button.getAttribute('data-category');
                    var productName = button.getAttribute('data-name');
                    var productPrice = button.getAttribute('data-price');
                    var productStocks = button.getAttribute('data-stocks');

                    // Update the modal's input fields
                    updateModal.querySelector('#product_id').value = productId;
                    updateModal.querySelector('#product_category').value = productCategory;
                    updateModal.querySelector('#product_name').value = productName;
                    updateModal.querySelector('#product_price').value = productPrice;
                    updateModal.querySelector('#product_stocks').value = productStocks;
                });
            });

            // script for deleting product
            document.addEventListener('DOMContentLoaded', function() {
                var deleteModal = document.getElementById('delete_product_modal');
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget; // Button that triggered the modal
                    var productId = button.getAttribute('data-id');

                    // Set the product ID in the hidden input field
                    deleteModal.querySelector('#delete_product_id').value = productId;
                });
            });

            // Detailed specifications
            const specifications = `
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>INTEL CORE i3-12100+GA-H610M-K-D4</td>
                            <td>₱10,945.00</td>
                        </tr>
                        <tr>
                            <td>ADATA 8GB DDR4-3200hz</td>
                            <td>₱1,150.00</td>
                        </tr>
                        <tr>
                            <td>ADATA 256Gb SATA III NAND SSD</td>
                            <td>₱1,200.00</td>
                        </tr>
                        <tr>
                            <td>HIKVISION DS-D5022FN10</td>
                            <td>₱2,950.00</td>
                        </tr>
                        <tr>
                            <td>21.5" 1080P, HDMI/VGA 75Hz</td>
                            <td>Included</td>
                        </tr>
                        <tr>
                            <td>INPLAY X10+GP200W Case+PSU Bundle</td>
                            <td>₱850.00</td>
                        </tr>
                        <tr>
                            <td>A4Tech USB Keyboard and Mouse</td>
                            <td>₱590.00</td>
                        </tr>
                        <tr>
                            <td>AVR Secure</td>
                            <td>₱290.00</td>
                        </tr>
                        <tr>
                            <td>Novus/Inplay Desktop Speaker</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>CPU ONLY</td>
                            <td>₱15,945.00</td>
                        </tr>
                    </tbody>
                </table>
            `;

            $(document).ready(function () {
                const table = $('#package_table').DataTable({
                    columnDefs: [
                        {
                            className: 'dt-control',
                            orderable: false,
                            data: null,
                            defaultContent: '',
                            targets: 0
                        }
                    ],
                    order: [[1, 'asc']]
                });

                // Add event listener for opening and closing details
                $('#package_table tbody').on('click', 'td.dt-control', function () {
                    const tr = $(this).closest('tr');
                    const row = table.row(tr);

                    if (row.child.isShown()) {
                        // Close the row details
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        // Open the row details
                        row.child(specifications).show();
                        tr.addClass('shown');
                    }
                });
            });
        </script>
    </body>
</html>