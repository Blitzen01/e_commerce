<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";
    include "../../render/modals.php"
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
                    <section id="product_section" class="my-2 px-4">
                        <h4 class="pt-3">Product List</h4>
                        <button class="btn p-1 mb-3 border border-1" data-bs-toggle="modal" data-bs-target="#add_product_modal"><i class="fa-solid fa-plus"></i> Add Product</button>
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
        </script>
    </body>
</html>