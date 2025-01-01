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
        <title>Admin: Staff</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">

    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col">
                    <h3 class="p-3 text-center"><i class="fa-solid fa-clipboard-user"></i> Staff</h3>
                    <section class="my-2 px-4">
                        <button class="btn btn-success p-1 mb-1 ms-3 text-light border-0">ADD STAFF</button>
                        <button class="btn btn-danger p-1 mb-1 text-light border-0">REMOVE STAFF</button>
                        <table class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Action</td>
                                    <td>Name</td>
                                    <td>Username</td>
                                    <td>Contact Number</td>
                                    <td>Position</td>
                                    <td>Address</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><button class="bg-success border-0 p-1 text-light">Update</button></td>
                                    <td>Aj Samson</td>
                                    <td>AJ</td>
                                    <td>09123456789</td>
                                    <td>Technical</td>
                                    <td>Borland</td>
                                </tr>
                                <tr>
                                    <td><button class="bg-success border-0 p-1 text-light">Update</button></td>
                                    <td>Aj Samson</td>
                                    <td>AJ</td>
                                    <td>09123456789</td>
                                    <td>Technical</td>
                                    <td>Borland</td>
                                </tr><tr>
                                    <td><button class="bg-success border-0 p-1 text-light">Update</button></td>
                                    <td>Aj Samson</td>
                                    <td>AJ</td>
                                    <td>09123456789</td>
                                    <td>Technical</td>
                                    <td>Borland</td>
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