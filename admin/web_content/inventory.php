<?php
    session_start();
    
    require_once "../../assets/cdn/cdn_links.php";
    require_once "../../render/connection.php";
    require_once "../../render/modals.php";
    
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
        <title>Admin: Inventory</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">
        <link rel="icon" href="/e_commerce/assets/image/hfa_logo.png" type="image/png">

        <style>
            #downloadCsvButtonPackage, #downloadCsvButton {
                background-color:rgb(24, 180, 219); /* Blue */
                color: white;
                border-radius: 0.25rem;
            }
            #downloadExcelButtonPackage, #downloadExcelButton {
                background-color:rgb(42, 196, 78); /* Green */
                color: white;
                border-radius: 0.25rem;
            }
            #downloadPdfButtonPackage, #downloadPdfButton {
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
                                    <th class="no-export">Actions</th>
                                    <th>Package</th>
                                    <th>Package Name</th>
                                    <th>Processor</th>
                                    <th>RAM</th>
                                    <th>SSD</th>
                                    <th>HDD</th>
                                    <th>Monitor</th>
                                    <th>Display</th>
                                    <th>PSU</th>
                                    <th>Keyboard and Mouse</th>
                                    <th>AVR</th>
                                    <th>Speaker</th>
                                    <th>CPU Only</th>
                                    <th>Stocks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM package";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr id="package_<?php echo $row['id']; ?>">
                                                <td></td>
                                                <td>
                                                    <button class="bg-success border-0 text-light p-1">Update</button> 
                                                    <button class="bg-danger border-0 text-light p-1">Delete</button>
                                                </td>
                                                <td>
                                                    <?php echo $row['package']; ?>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['package_name']; ?> <br>Price: </b>
                                                    &#8369; <?php echo number_format($row['package_price'], 2); ?>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['processor']; ?> <br>Price: </b>
                                                    &#8369;  <?php echo number_format($row['processor_price'], 2); ?>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['ram']; ?> <br>Price: </b>
                                                    &#8369; <?php echo number_format($row['ram_price']); ?>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['ssd']; ?> <br> Price: </b>
                                                    &#8369; <?php echo $row['ssd_price']; ?>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['hdd']; ?> <br> </b>
                                                    <?php if ($row['hdd_price'] != null && $row['hdd_price'] != 0): echo "&#8369;" + $row['hdd_price']; endif;?>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['monitor']; ?> <br> Price:</b>
                                                    &#8369; <?php echo number_format($row['monitor_price']); ?>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['display']; ?> <br> Price: </b>
                                                    &#8369; <?php echo number_format($row['display_price']); ?>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['psu']; ?> <br> Price: </b>
                                                    &#8369; <?php echo number_format($row['psu_price']); ?>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['keyboard_mouse']; ?> <br> Price: </b>
                                                    &#8369; <?php echo number_format($row['keyboard_mouse_price']); ?>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['avr']; ?> <br> Price:</b>
                                                    &#8369; <?php echo number_format($row['avr_price']); ?>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['speaker']; ?> - </b> <?php if ($row['speaker_price'] != null && $row['speaker_price'] != 0): echo number_format($row['speaker_price']); endif;?>
                                                </td>
                                                <td>
                                                    <b>&#8369; <?php echo number_format($row['cpu_only']); ?></b>
                                                </td>
                                                <td>
                                                    <b><?php echo $row['stocks']; ?></b>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
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
                                            <tr id="product_<?php echo $row['id']; ?>">
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

                var dataTablePackage = $('#package_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'csv',
                            text: 'CSV',
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadCsvButtonPackage'); // Set unique ID for CSV button
                                $(node).addClass('btn btn-primary rounded'); // Blue button for CSV
                            },
                            filename: 'Package List',
                            exportOptions: {
                                columns: ':not(.no-export)', // Exclude columns with 'no-export' class
                                format: {
                                    body: function(data, row, column, node) {
                                        // Handle content with newlines or spaces
                                        var tempDiv = document.createElement('div');
                                        tempDiv.innerHTML = data; // Parse HTML content
                                        var textData = tempDiv.textContent || tempDiv.innerText || ''; // Extract plain text
                                        
                                        // Remove peso sign and unnecessary spaces/newlines
                                        textData = textData.replace(/₱|&#8369;/g, '').trim(); // Remove peso sign
                                        return textData.replace(/\s*\n\s*/g, ' '); // Remove newline and excess spaces
                                    }
                                }
                            }
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadExcelButtonPackage'); // Set unique ID for Excel button
                                $(node).addClass('btn btn-success rounded'); // Green button for Excel
                            },
                            filename: 'Package List',
                            exportOptions: {
                                columns: ':not(.no-export)', // Exclude columns with 'no-export' class
                                format: {
                                    body: function(data, row, column, node) {
                                        // Handle content with newlines or spaces
                                        var tempDiv = document.createElement('div');
                                        tempDiv.innerHTML = data; // Parse HTML content
                                        var textData = tempDiv.textContent || tempDiv.innerText || ''; // Extract plain text
                                        
                                        // Remove peso sign and unnecessary spaces/newlines
                                        textData = textData.replace(/₱|&#8369;/g, '').trim(); // Remove peso sign
                                        return textData.replace(/\s*\n\s*/g, ' '); // Remove newline and excess spaces
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadPdfButtonPackage'); // Set unique ID for PDF button
                                $(node).addClass('btn btn-danger rounded'); // Red button for PDF
                            },
                            filename: 'Package List',
                            exportOptions: {
                                columns: ':not(.no-export)', // Exclude columns with 'no-export' class
                                format: {
                                    body: function(data, row, column, node) {
                                        // Handle content with newlines or spaces
                                        var tempDiv = document.createElement('div');
                                        tempDiv.innerHTML = data; // Parse HTML content
                                        var textData = tempDiv.textContent || tempDiv.innerText || ''; // Extract plain text
                                        
                                        // Remove peso sign and unnecessary spaces/newlines
                                        textData = textData.replace(/₱|&#8369;/g, '').trim(); // Remove peso sign
                                        return textData.replace(/\s*\n\s*/g, ' '); // Remove newline and excess spaces
                                    }
                                }
                            },
                            customize: function(doc) {
                                // Set PDF layout to landscape
                                doc.pageOrientation = 'landscape';
                                
                                // Ensure that the PDF has simple styling (plain text)
                                doc.styles.tableBodyEven.alignment = 'left';
                                doc.styles.tableBodyOdd.alignment = 'left';
                                doc.defaultStyle.fontSize = 10; // Keep font size small and plain
                            }
                        }
                    ],
                    columnDefs: [
                        {
                            className: 'dtr-control',
                            orderable: false,
                            target: 0
                        },
                        {
                            targets: 'no-export', // Targets columns with 'no-export' class
                            visible: true,
                            searchable: false
                        }
                    ],
                    order: [1, 'asc'],
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    }
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