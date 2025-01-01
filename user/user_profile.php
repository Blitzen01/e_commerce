<?php
    session_start();

    $email = $_SESSION['email'];
    
    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>

        <div class="m-3">
            <div class="container">
                <h3 class="p-3 text-center"><i class="fa-solid fa-user"></i> Account Settings</h3>
                <section class="my-2 px-4">
                    <div class="row">
                        <?php
                            $sql = "SELECT * FROM user_account WHERE email = '$email'";
                            $result = mysqli_query($conn, $sql);

                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <div class="col-lg-3 col-sm-11 text-center">
                                        <div class="dropdown">
                                            <div id="square-image-container">
                                                <a class="btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img class="rounded-circle" id="profile_picture" src="../assets/image/profile_picture/blank_profile_picture.png" alt="" srcset="">
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="btn drop-item" data-bs-toggle="modal" data-bs-target="#update_profile_picture_modal">Update profile picture</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-sm-11 px-5">
                                        <div class="row shadow">
                                            <h4 class="bg-secondary bg-opacity-25 border-bottom">Personal Information</h4>
                                            <div class="col-lg-6 col-sm-11">
                                                <h5><strong>Name: </strong> <?php echo $row['full_name']; ?></h5>
                                            </div>
                                            <div class="col-lg-6 col-sm-11">
                                                <h5><strong>Password: </strong>
                                                    <?php
                                                        $password = $row['password'];
                                                        echo str_repeat('*', strlen($password));
                                                    ?>
                                                </h5>
                                                <button class="nav-link text-primary ms-3" data-bs-toggle="modal" data-bs-target="#change_password_modal"><u>change password</u></button>
                                            </div>
                                            <div class="col-lg-6 col-sm-11">
                                                <h5><strong>Email: </strong> <?php echo $row['email']; ?></h5>
                                            </div>
                                            <div class="col-lg-6 col-sm-11">
                                                <h5><strong>Address: </strong> <?php echo $row['address']; ?></h5>
                                            </div>
                                            <div class="col-lg-6 col-sm-11">
                                                <h5><strong>Contact Number: </strong>
                                                    <?php 
                                                        $contactNumber = $row['contact_number'];
                                                        $formattedNumber = substr($contactNumber, 0, 4) . '-' . 
                                                                        substr($contactNumber, 4, 3) . '-' . 
                                                                        substr($contactNumber, 7);
                                                        echo $formattedNumber; 
                                                    ?>
                                                </h5>
                                            </div>
                                            <div class="col-lg-6 col-sm-11">
                                                <h5><strong>Birthday: </strong> <?php echo $row['birthday']; ?></h5>
                                            </div>
                                            <div class="col-lg-6 col-sm-11">
                                                <h5><strong>Gender: </strong> <?php echo strtoupper($row['gender']); ?></h5>
                                            </div>
                                            <div class="col-lg-6 col-sm-11">
                                                <h5><strong>Age: </strong> <?php echo strtoupper($row['age']); ?></h5>
                                            </div>
                                            <div class="col-lg-6 col-sm-11">
                                                <h5><strong>Account Created: </strong> <?php echo strtoupper($row['created']); ?></h5>
                                            </div>
                                            <hr class="mx-auto" style="width:80%;">
                                            <h5><strong>Bio: </strong> <?php echo $row['bio']; ?></h5>
                                            <button class="btn btn-danger w-100 text-light" data-bs-toggle="modal" data-bs-target="#user_update_profile_information_modal">Update Profile</button>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </section>

                <br>

                <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Bookings</h3>
                <section class="my-2 px-4">
                    <div class="row text-center">
                        <div class="col">
                            <button class="btn btn-danger w-100 border-0 rounded-0" onclick="showTable('booking', 'booking_transaction')">Booking</button>
                        </div>
                        <div class="col">
                            <button class="btn btn-dark w-100 border-0 rounded-0" onclick="showTable('booking_transaction', 'booking')">Transactions</button>
                        </div>
                    </div>
                    <table id="booking" class="table table-sm nowrap table-striped compact table-hover border">
                        <thead class="table-secondary">
                            <tr>
                                <td>Type of Booking</td>
                                <td>Time</td>
                                <td>Date</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $booked = "SELECT * FROM booked WHERE email ='$email'";
                                $result = mysqli_query($conn, $booked);

                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $formattedDate = date('m/d/Y', strtotime($row['date'])); // Format date as MM/DD/YYYY
                                        $formattedTime = date('h:i A', strtotime($row['time'])); // Format time as 12-hour with AM/PM
                                        ?>
                                        <tr>
                                            <td><?php echo $row['type_of_booking']; ?></td>
                                            <td><?php echo $formattedTime; ?></td>
                                            <td><?php echo $formattedDate; ?></td>
                                            <td><span class="text-secondary">On Hold</span></td>
                                        </tr>
                                        <?php
                                    }
                                }

                                $booking = "SELECT * FROM booking WHERE email ='$email'";
                                $result1 = mysqli_query($conn, $booking);

                                if ($result1) {
                                    while ($row = mysqli_fetch_assoc($result1)) {
                                        $formattedDate = date('m/d/Y', strtotime($row['date'])); // Format date as MM/DD/YYYY
                                        $formattedTime = date('h:i A', strtotime($row['time'])); // Format time as 12-hour with AM/PM
                                        ?>
                                        <tr>
                                            <td><?php echo $row['type_of_booking']; ?></td>
                                            <td><?php echo $formattedTime; ?></td>
                                            <td><?php echo $formattedDate; ?></td>
                                            <td><span class="text-success">Processing</span></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>

                    <table id="booking_transaction" class="table table-sm nowrap table-striped compact table-hover border" style="display: none;>
                        <thead class="table-secondary">
                            <tr>
                                <td>Type of Booking</td>
                                <td>Time</td>
                                <td>Date</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $transaction = "SELECT * FROM transaction_history WHERE email ='$email'";
                                $result = mysqli_query($conn, $transaction);

                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $formattedDate = date('m/d/Y', strtotime($row['date'])); // Format date as MM/DD/YYYY
                                        $formattedTime = date('h:i A', strtotime($row['time'])); // Format time as 12-hour with AM/PM
                                        ?>
                                        <tr>
                                            <td><?php echo $row['type_of_booking']; ?></td>
                                            <td><?php echo $formattedTime; ?></td>
                                            <td><?php echo $formattedDate; ?></td>
                                            <td><?php echo $row['staus']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </section>

                <br>

                <h3 class="p-3 text-center"><i class="fa-solid fa-shop"></i> Orders</h3>
                <section class="my-2 px-4">
                    <div class="row text-center">
                        <div class="col">
                            <button class="btn btn-danger w-100 border-0 rounded-0" onclick="showTable('order', 'order_transaction')">Orders</button>
                        </div>
                        <div class="col">
                            <button class="btn btn-dark w-100 border-0 rounded-0" onclick="showTable('order_transaction', 'order')">Transactions</button>
                        </div>
                    </div>
                    <table id="order" class="table table-sm nowrap table-striped compact table-hover border">
                        <thead class="table-secondary">
                            <tr>
                                <td>Item Name</td>
                                <td>Item Qty.</td>
                                <td>Total Price</td>
                                <td>Mode of Payment</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $order_booking = "SELECT * FROM order_booking WHERE email ='$email'";
                                $result = mysqli_query($conn, $order_booking);

                                if ($result) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['item']; ?></td>
                                            <td><?php echo $row['quantity']; ?></td>
                                            <td><?php echo $row['price']; ?></td>
                                            <td><?php echo strtoupper($row['mop']); ?></td>
                                            <td><span class="text-secondary">On Hold</span></td>
                                        </tr>
                                        <?php
                                    }
                                }

                                $order_booked = "SELECT * FROM order_booked WHERE email ='$email'";
                                $result = mysqli_query($conn, $order_booked);

                                if ($result) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['item']; ?></td>
                                            <td><?php echo $row['quantity']; ?></td>
                                            <td><?php echo $row['price']; ?></td>
                                            <td><?php echo strtoupper($row['mop']); ?></td>
                                            <td><span class="text-success">Processing</span></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>

                    <table id="order_transaction" class="table table-sm nowrap table-striped compact table-hover border" style="display: none;">
                        <thead class="table-secondary">
                            <tr>
                                <td>Item Name</td>
                                <td>Item Qty.</td>
                                <td>Total Price</td>
                                <td>Mode of Payment</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $order_transaction = "SELECT * FROM order_transaction_history WHERE email ='$email'";
                                $result = mysqli_query($conn, $order_transaction);

                                if ($result) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['item']; ?></td>
                                            <td><?php echo $row['quantity']; ?></td>
                                            <td><?php echo $row['price']; ?></td>
                                            <td><?php echo strtoupper($row['mop']); ?></td>
                                            <td><?php echo $row['status']; ?></td>
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

        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>

        <script>
            function showTable(showId, hideId) {
                // Show the specified table
                document.getElementById(showId).style.display = '';
                // Hide the other table
                document.getElementById(hideId).style.display = 'none';
            }
        </script>
    </body>
</html>