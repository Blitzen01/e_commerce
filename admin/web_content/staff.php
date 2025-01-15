<?php
    session_start();

    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";
    include "../../render/modals.php";
    
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
        <title>Admin: Staff</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">
        <link rel="icon" href="/e_commerce/assets/image/hfa_logo.png" type="image/png">

    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col">
                    <?php include "../../navigation/admin_header.php"; ?>
                    <h3 class="p-3 text-center"><i class="fa-solid fa-clipboard-user"></i> Active Staff</h3>
                    <section class="my-2 px-4">
                        <button class="btn btn-success p-1 mb-1 ms-3 text-light border-0" data-bs-toggle="modal" data-bs-target="#add_staff">ADD STAFF</button>
                        <button class="btn btn-danger p-1 mb-1 text-light border-0" data-bs-toggle="modal" data-bs-target="#remove_staff">Archive STAFF</button>
                        <table id="staff_table" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Name</td>
                                    <td>Username</td>
                                    <td>Contact Number</td>
                                    <td>Position</td>
                                    <td>Address</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM admin_account";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></td>
                                                <td><?php echo $row['username']; ?></td>
                                                <td><?php echo $row['contact_number']; ?></td>
                                                <td><?php echo $row['role']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </section>

                    <h3 class="p-3 text-center"><i class="fa-solid fa-clipboard-user"></i> Archive Staff</h3>
                    <section class="my-2 px-4">
                        <table id="arcive_staff_table" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Name</td>
                                    <td>Username</td>
                                    <td>Contact Number</td>
                                    <td>Position</td>
                                    <td>Address</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM archive_staff";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></td>
                                                <td><?php echo $row['username']; ?></td>
                                                <td><?php echo $row['contact_number']; ?></td>
                                                <td><?php echo $row['role']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
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
                var table_booking = $('#staff_table').DataTable({
                    scrollX: true,
                    autoWidth: false
                });
                var table_booking = $('#arcive_staff_table').DataTable({
                    scrollX: true,
                    autoWidth: false
                });
            });
        </script>
    </body>
</html>