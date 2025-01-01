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
                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Booked</h3>
                    <section class="my-2 px-4">
                        <table id="table_booking" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Action</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Address</td>
                                    <td>Contact Number</td>
                                    <td>Scheduled Date</td>
                                    <td>Scheduled Time</td>
                                    <td>Type of Booking</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $sql = "SELECT * FROM booked";
                                        $result = mysqli_query($conn, $sql);

                                        if($result) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                $formattedDate = date("F j, Y", strtotime($row['date'])); // Month Day, Year
                                                $formattedTime = date("g:i A", strtotime($row['time']));  // 12-hour format with AM/PM
                                                ?>
                                                <tr>
                                                    <td>
                                                        <button class="bg-success border-0 p-1 text-light" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#accept_booking<?php echo $row["id"]; ?>">
                                                            Accept
                                                        </button>
                                                        <button class="bg-danger border-0 p-1 text-light">Decline</button>
                                                    </td>
                                                    <td><?php echo $row['name']; ?></td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td><?php echo $row['address']; ?></td>
                                                    <td><?php echo $row['contact_number']; ?></td>
                                                    <td><?php echo $formattedDate; ?></td>
                                                    <td><?php echo $formattedTime; ?></td>
                                                    <td><?php echo $row['type_of_booking']; ?></td>
                                                    
                                                </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                            </tbody>
                        </table>
                    </section>

                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Bookings</h3>
                    <section class="my-2 px-4">
                    <table id="table_booked" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Action</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Address</td>
                                    <td>Contact Number</td>
                                    <td>Scheduled Date</td>
                                    <td>Type of Booking</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </section>

                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Transaction History</h3>
                    <section class="my-2 px-4">
                    <table id="table_transaction_history" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Action</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Address</td>
                                    <td>Contact Number</td>
                                    <td>Scheduled Date</td>
                                    <td>Type of Booking</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </div>


        <script src="../../assets/script/admin_script.js"></script>

        <script>
            $(document).ready(function () {
                var table_booking = $('#table_booking').DataTable();

                var table_booked = $('#table_booked').DataTable();

                var table_booked = $('#table_transaction_history').DataTable();
            });
        </script>
    </body>
</html>