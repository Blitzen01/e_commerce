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
                        <button class="btn p-1 mb-3 border border-1" data-bs-toggle="modal" data-bs-target="#add_package">
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
                                                    <button
                                                        class="bg-success border-0 text-light p-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#update_package_<?php echo $row['id']; ?>">Update</button> 
                                                    <button
                                                        class="bg-danger border-0 text-light p-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#delete_package_<?php echo $row['id']; ?>">Delete</button>
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
                                                    <b><?php echo isset($row['hdd']) && !empty($row['hdd']) ? $row['hdd'] : '-'; ?> <br> Price: </b>
                                                    &#8369; <?php echo $row['hdd_price']; ?>
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

<!-- add package -->
<div class="modal fade" id="add_package" tabindex="-1" aria-labelledby="add_package_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add_package_label">Add Package</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../assets/php_script/add_package_script.php" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="package_image">Package Image</label>
                        <input type="file" class="form-control" name="package_image" id="package_image" accept="image/*" required>
                    </div>
                    <div class="mb-4">
                        <label for="package">Package</label>
                        <input type="text" class="form-control" name="package" id="package" autocomplete="off">
                        <label for="package_price">Package Price</label>
                        <input type="number" class="form-control" name="package_price" id="package_price" required autocomplete="off">
                    </div>
                    <div class="mb-4">
                        <label for="package_name">Package Name</label>
                        <input type="text" class="form-control" name="package_name" id="package_name" required autocomplete="off">
                    </div>
                    <div class="mb-4">
                        <label for="processor">Processor</label>
                        <input type="text" class="form-control" name="processor" id="processor" required autocomplete="off">
                        <label for="processor_price">Processor Price</label>
                        <input type="number" class="form-control" name="processor_price" id="processor_price" required autocomplete="off">
                    </div>
                    <div class="mb-4">
                        <label for="ram">RAM</label>
                        <input type="text" class="form-control" name="ram" id="ram" required autocomplete="off">
                        <label for="ram_price">RAM Price</label>
                        <input type="number" class="form-control" name="ram_price" id="ram_price" required autocomplete="off">
                    </div>
                    <div class="mb-4">
                        <label for="ssd">SSD</label>
                        <input type="text" class="form-control" name="ssd" id="ssd" required autocomplete="off">
                        <label for="ssd_price">SSD Price</label>
                        <input type="number" class="form-control" name="ssd_price" id="ssd_price" required autocomplete="off">
                    </div>
                    <div class="mb-4">
                        <label for="hdd">HDD</label>
                        <input type="text" class="form-control" name="hdd" id="hdd">
                        <label for="hdd_price">HDD Price</label>
                        <input type="number" class="form-control" name="hdd_price" id="hdd_price">
                    </div>
                    <div class="mb-4">
                        <label for="monitor">Monitor</label>
                        <input type="text" class="form-control" name="monitor" id="monitor" required autocomplete="off">
                        <label for="monitor_price">Monitor Price</label>
                        <input type="number" class="form-control" name="monitor_price" id="monitor_price" required autocomplete="off">
                    </div>
                    <div class="mb-4">
                        <label for="display">Display</label>
                        <input type="text" class="form-control" name="display" id="display" required autocomplete="off">
                        <label for="display_price">Display Price</label>
                        <input type="number" class="form-control" name="display_price" id="display_price" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="psu">PSU</label>
                        <input type="text" class="form-control" name="psu" id="psu" required autocomplete="off">
                        <label for="psu_price">PSU Price</label>
                        <input type="number" class="form-control" name="psu_price" id="psu_price" required autocomplete="off">
                    </div>
                    <div class="mb-4">
                        <label for="keyboard_mouse">Keyboard and Mouse</label>
                        <input type="text" class="form-control" name="keyboard_mouse" id="keyboard_mouse" required autocomplete="off">
                        <label for="keyboard_mouse_price">Keyboard and Mouse Price</label>
                        <input type="number" class="form-control" name="keyboard_mouse_price" id="keyboard_mouse_price" required autocomplete="off">
                    </div>
                    <div class="mb-4">
                        <label for="avr">AVR</label>
                        <input type="text" class="form-control" name="avr" id="avr" required autocomplete="off">
                        <label for="avr_price">AVR Price</label>
                        <input type="number" class="form-control" name="avr_price" id="avr_price" required autocomplete="off">
                    </div>
                    <div class="mb-4">
                        <label for="speaker">Speaker</label>
                        <input type="text" class="form-control" name="speaker" id="speaker required autocomplete="off"">
                        <label for="speaker_price">Speaker Price</label>
                        <input type="number" class="form-control" name="speaker_price" id="speaker_price" required autocomplete="off">
                    </div>
                    <div class="mb-4">
                        <label for="cpu_only">CPU only</label>
                        <input type="text" class="form-control" name="cpu_only" id="cpu_only" required autocomplete="off">
                    </div>
                    <div class="mb-4">
                        <label for="stocks">Stocks</label>
                        <input type="number" class="form-control" name="stocks" id="stocks" required autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Package Modal -->
<?php
$sql = "SELECT * FROM package";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="modal fade" id="update_package_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updatePackageLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updatePackageLabel">Update Package</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../../assets/php_script/update_package_script.php" method="post">
                            <!-- Hidden field for package ID -->
                            <input type="hidden" name="package_id" value="<?php echo $row['id']; ?>">

                            <!-- Package -->
                            <div class="mb-3">
                                <label for="package" class="form-label">Package</label>
                                <input type="text" class="form-control" id="package" name="package" value="<?php echo $row['package']; ?>" required>
                            </div>

                            <!-- Package Name -->
                            <div class="mb-3">
                                <label for="packageName" class="form-label">Package Name</label>
                                <input type="text" class="form-control" id="packageName" name="package_name" value="<?php echo $row['package_name']; ?>" required>
                            </div>

                            <!-- Package Price -->
                            <div class="mb-3">
                                <label for="package_price" class="form-label">Package Price</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="package_price" value="<?php echo $row['package_price']; ?>" required>
                            </div>

                            <!-- Processor -->
                            <div class="mb-3">
                                <label for="processor" class="form-label">Processor</label>
                                <input type="text" class="form-control" id="processor" name="processor" value="<?php echo $row['processor']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="processorPrice" class="form-label">Processor Price</label>
                                <input type="number" step="0.01" class="form-control" id="processorPrice" name="processor_price" value="<?php echo $row['processor_price']; ?>" required>
                            </div>

                            <!-- RAM -->
                            <div class="mb-3">
                                <label for="ram" class="form-label">RAM</label>
                                <input type="text" class="form-control" id="ram" name="ram" value="<?php echo $row['ram']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="ramPrice" class="form-label">RAM Price</label>
                                <input type="number" step="0.01" class="form-control" id="ramPrice" name="ram_price" value="<?php echo $row['ram_price']; ?>">
                            </div>

                            <!-- SSD -->
                            <div class="mb-3">
                                <label for="ssd" class="form-label">SSD</label>
                                <input type="text" class="form-control" id="ssd" name="ssd" value="<?php echo $row['ssd']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="ssdPrice" class="form-label">SSD Price</label>
                                <input type="number" step="0.01" class="form-control" id="ssdPrice" name="ssd_price" value="<?php echo $row['ssd_price']; ?>">
                            </div>

                            <!-- HDD -->
                            <div class="mb-3">
                                <label for="hdd" class="form-label">HDD</label>
                                <input type="text" class="form-control" id="hdd" name="hdd" value="<?php echo $row['hdd']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="hddPrice" class="form-label">HDD Price</label>
                                <input type="number" step="0.01" class="form-control" id="hddPrice" name="hdd_price" value="<?php echo $row['hdd_price']; ?>">
                            </div>

                            <!-- Monitor -->
                            <div class="mb-3">
                                <label for="monitor" class="form-label">Monitor</label>
                                <input type="text" class="form-control" id="monitor" name="monitor" value="<?php echo $row['monitor']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="monitorPrice" class="form-label">Monitor Price</label>
                                <input type="number" step="0.01" class="form-control" id="monitorPrice" name="monitor_price" value="<?php echo $row['monitor_price']; ?>">
                            </div>

                            <!-- Display -->
                            <div class="mb-3">
                                <label for="display" class="form-label">Display</label>
                                <input type="text" class="form-control" id="display" name="display" value="<?php echo $row['monitor']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="display_price" class="form-label">Display Price</label>
                                <input type="number" step="0.01" class="form-control" id="display_price" name="display_price" value="<?php echo $row['display_price']; ?>">
                            </div>

                            <!-- PSU -->
                            <div class="mb-3">
                                <label for="psu" class="form-label">PSU</label>
                                <input type="text" class="form-control" id="psu" name="psu" value="<?php echo $row['psu']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="psuPrice" class="form-label">PSU Price</label>
                                <input type="number" step="0.01" class="form-control" id="psuPrice" name="psu_price" value="<?php echo $row['psu_price']; ?>">
                            </div>

                            <!-- Keyboard and Mouse -->
                            <div class="mb-3">
                                <label for="keyboard_mouse" class="form-label">Keyboard and Mouse</label>
                                <input type="text" class="form-control" id="keyboard_mouse" name="keyboard_mouse" value="<?php echo $row['keyboard_mouse']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="keyboard_mouse_price" class="form-label">Keyboard and Mouse Price</label>
                                <input type="number" step="0.01" class="form-control" id="keyboard_mouse_price" name="keyboard_mouse_price" value="<?php echo $row['keyboard_mouse_price']; ?>">
                            </div>

                            <!-- AVR -->
                            <div class="mb-3">
                                <label for="avr" class="form-label">AVR</label>
                                <input type="text" class="form-control" id="avr" name="avr" value="<?php echo $row['avr']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="avr_price" class="form-label">AVR Price</label>
                                <input type="number" step="0.01" class="form-control" id="avr_price" name="avr_price" value="<?php echo $row['avr_price']; ?>">
                            </div>

                            <!-- Speaker -->
                            <div class="mb-3">
                                <label for="speaker" class="form-label">Speaker</label>
                                <input type="text" class="form-control" id="speaker" name="speaker" value="<?php echo $row['speaker']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="speaker_price" class="form-label">Speaker Price</label>
                                <input type="number" step="0.01" class="form-control" id="speaker_price" name="speaker_price" value="<?php echo $row['speaker_price']; ?>">
                            </div>

                            <!-- stocks -->
                            <div class="mb-3">
                                <label for="stocks" class="form-label">Stocks</label>
                                <input type="number" step="0.01" class="form-control" id="stocks" name="stocks" value="<?php echo $row['stocks']; ?>">
                            </div>

                            <!-- cpu only -->
                            <div class="mb-3">
                                <label for="cpu_only" class="form-label">CPU Only</label>
                                <input type="number" step="0.01" class="form-control" id="cpu_only" name="cpu_only" value="<?php echo $row['cpu_only']; ?>">
                            </div>

                            <!-- Submit Button -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save Changes</button>
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

<!-- delete package -->
<?php
$sql = "SELECT * FROM package";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="modal fade" id="delete_package_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Make modal larger for better readability -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Package Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Are you sure you want to delete this package?</h4>
                        <hr>
                        <!-- Display Package Details -->
                        <div class="package-details">
                            <p><strong>Package Name:</strong> <?php echo $row['package_name']; ?></p>
                            <p><strong>Price:</strong> ₱<?php echo number_format($row['package_price'], 2); ?></p>
                            <p><strong>Processor:</strong> <?php echo $row['processor']; ?></p>
                            <p><strong>Details:</strong></p>
                            <ul>
                                <li>RAM: <?php echo $row['ram']; ?></li>
                                <li>SSD: <?php echo $row['ssd']; ?></li>
                                <li>HDD: <?php echo $row['hdd']; ?></li>
                                <li>Monitor: <?php echo $row['monitor']; ?></li>
                                <li>PSU: <?php echo $row['psu']; ?></li>
                                <li>Keyboard and Mouse: <?php echo $row['keyboard_mouse']; ?></li>
                                <li>AVR: <?php echo $row['avr']; ?></li>
                                <li>Speaker: <?php echo $row['speaker']; ?></li>
                            </ul>
                            <p><strong>Stocks:</strong> <?php echo $row['stocks']; ?></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="../../assets/php_script/delete_package_script.php" method="post">
                            <input type="hidden" name="package_id" value="<?php echo $row['id']; ?>">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>