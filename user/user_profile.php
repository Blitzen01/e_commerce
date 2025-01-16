<?php
session_start();

include "../assets/cdn/cdn_links.php";
include "../render/connection.php";
include "../render/modals.php";

$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link rel="stylesheet" href="../assets/style/user_style.css">

    <style>
        .modal-dialog {
            max-height: calc(100% - 1rem); /* Ensures the modal does not overflow the viewport */
            overflow-y: auto; /* Enables vertical scrolling within the modal */
        }

        .modal-body {
            max-height: 70vh; /* Adjust as needed */
            overflow-y: auto; /* Ensures the scroll is inside the modal body */
        }
    </style>
</head>

<body>
    <?php include "../navigation/user_nav.php"; ?>
    <?php include "chat.php"; ?>

    <div class="m-3">
        <div class="container">
            <h3 class="p-3 text-center"><i class="fa-solid fa-user"></i> Account Settings</h3>
            <section class="my-2 px-4">
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM user_account WHERE email = '$email'";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="col-lg-3 col-sm-11 text-center">
                                <div class="dropdown">
                                    <div id="square-image-container">
                                        <a class="btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php
                                                // Determine the profile picture file path
                                                $profilePicturePath = "../assets/image/profile_picture/" . $row['profile_picture'];

                                                // Check if the file exists and set the image source
                                                $profilePictureSrc = (isset($row['profile_picture']) && !empty($row['profile_picture']) && file_exists($profilePicturePath))
                                                    ? htmlspecialchars($row['profile_picture'], ENT_QUOTES, 'UTF-8')
                                                    : "blank_profile_picture.png";
                                            ?>

                                            <img class="rounded-circle" id="profile_picture"
                                                src="../assets/image/profile_picture/<?php echo $profilePictureSrc; ?>"
                                                alt="Profile Picture" />

                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="btn drop-item" data-bs-toggle="modal"
                                                    data-bs-target="#update_profile_picture_modal">Update profile picture</a>
                                            </li>
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
                                            echo str_repeat('*', min(strlen($password), 13));
                                            ?>
                                        </h5>
                                        <button class="nav-link text-primary ms-3" data-bs-toggle="modal"
                                            data-bs-target="#change_user_password_modal"><u><small>change password</small></u></button>
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
                                            $formattedNumber = substr($contactNumber ?? '', 0, 4) . '-' .
                                                substr($contactNumber ?? '', 4, 3) . '-' .
                                                substr($contactNumber ?? '', 7);
                                            echo $formattedNumber;
                                            ?>
                                        </h5>
                                    </div>
                                    <div class="col-lg-6 col-sm-11">
                                        <h5><strong>Birthday: </strong> <?php echo $row['birthday']; ?></h5>
                                    </div>
                                    <div class="col-lg-6 col-sm-11">
                                        <h5><strong>Gender: </strong> <?php echo strtoupper($row['gender'] ?? ''); ?></h5>
                                    </div>
                                    <div class="col-lg-6 col-sm-11">
                                        <h5><strong>Age: </strong> <?php echo strtoupper($row['age'] ?? ''); ?></h5>
                                    </div>
                                    <div class="col-lg-6 col-sm-11">
                                        <h5><strong>Account Created: </strong> <?php echo strtoupper($row['created'] ?? ''); ?>
                                        </h5>
                                    </div>
                                    <hr class="mx-auto" style="width:80%;">
                                    <h5><strong>Bio: </strong> <?php echo $row['bio']; ?></h5>
                                    <button class="btn btn-danger w-100 text-light" data-bs-toggle="modal"
                                        data-bs-target="#update_user_profile_modal">Update Profile</button>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </section>

            <br>

            <h3 class="p-3 text-center" id="profile_booking_view"><i class="fa-solid fa-book"></i> Bookings</h3>
            <section class="my-2 px-4">
                <div class="row text-center">
                    <div class="col">
                        <button class="btn btn-danger w-100 border-0 rounded-0"
                            onclick="showTable('booking', 'booking_transaction')">Booking</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-dark w-100 border-0 rounded-0"
                            onclick="showTable('booking_transaction', 'booking')">Transactions</button>
                    </div>
                </div>
                <table id="booking" class="table table-sm nowrap table-striped compact table-hover border">
                    <thead class="table-secondary">
                        <tr>
                            <td>Type of Booking</td>
                            <td>Price</td>
                            <td>Time</td>
                            <td>Date</td>
                            <td>Remarks</td>
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
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $formattedTime; ?></td>
                                    <td><?php echo $formattedDate; ?></td>
                                    <td><?php echo $row['remarks']; ?></td>
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
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $formattedTime; ?></td>
                                    <td><?php echo $formattedDate; ?></td>
                                    <td><?php echo $row['remarks']; ?></td>
                                    <td><span class="text-success"><?php echo $row['status']; ?></span></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <table id="booking_transaction" class="table table-sm nowrap table-striped compact table-hover border"
                    style="display: none;">
                    <thead class="table-secondary">
                        <tr>
                            <td>Type of Booking</td>
                            <td>Price</td>
                            <td>Time</td>
                            <td>Date</td>
                            <td>Status</td>
                            <td>remarks</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $transaction = "SELECT * FROM transaction_history WHERE email ='$email'";
                        $result = mysqli_query($conn, $transaction);

                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $formattedDate = date('m/d/Y', strtotime($row['transaction_date'])); // Format date as MM/DD/YYYY
                                $formattedTime = date('h:i A', strtotime($row['time'])); // Format time as 12-hour with AM/PM
                                ?>
                                <tr>
                                    <td><?php echo $row['type_of_booking']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $formattedTime; ?></td>
                                    <td><?php echo $formattedDate; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td><?php echo $row['remarks']; ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <br>

            <h3 class="p-3 text-center" id="profile_order_view"><i class="fa-solid fa-shop"></i> Orders</h3>
            <section class="my-2 px-4">
                <div class="row text-center">
                    <div class="col">
                        <button class="btn btn-danger w-100 border-0 rounded-0"
                            onclick="showTable('order', 'order_transaction')">Orders</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-dark w-100 border-0 rounded-0"
                            onclick="showTable('order_transaction', 'order')">Transactions</button>
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
                            while ($row = mysqli_fetch_assoc($result)) {
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
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['item']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo strtoupper($row['mop']); ?></td>
                                    <td><span class="text-success"><?php echo $row['status']; ?></span></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <table id="order_transaction" class="table table-sm nowrap table-striped compact table-hover border"
                    style="display: none;">
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
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['item']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['total_amount']; ?></td>
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
        // Get today's date in the format YYYY-MM-DD
        const today = new Date().toISOString().split('T')[0];
            
        // Set the min attribute of the date input to today's date
        document.getElementById('dateInput').setAttribute('min', today);
    </script>
</body>

</html>

<?php
$sql = "SELECT * FROM user_account WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <!-- Modal -->
        <div class="modal fade" id="update_user_profile_modal" tabindex="-1" aria-labelledby="update_profile_label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="update_profile_label">Update User Profile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../assets/php_script/update_user_profile.php" method="post">

                            <!-- Hidden field to pass user ID -->
                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label for="full_name" class="form-label"><strong>Full Name</strong></label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                    value="<?php echo $row['full_name']; ?>" required>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label"><strong>Address</strong></label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="<?php echo $row['address']; ?>" required>
                            </div>

                            <!-- Contact Number -->
                            <div class="mb-3">
                                <label for="contact_number" class="form-label"><strong>Contact Number</strong></label>
                                <input type="text" class="form-control" id="contact_number" name="contact_number"
                                    value="<?php echo $row['contact_number']; ?>" required>
                            </div>

                            <!-- Birthday -->
                            <div class="mb-3">
                                <label for="birthday" class="form-label"><strong>Birthday</strong></label>
                                <input type="date" class="form-control" id="birthday" name="birthday"
                                    value="<?php echo $row['birthday']; ?>" required>
                            </div>

                            <!-- Gender -->
                            <div class="mb-3">
                                <label for="gender" class="form-label"><strong>Gender</strong></label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="male" <?php echo $row['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                    <option value="female" <?php echo $row['gender'] == 'female' ? 'selected' : ''; ?>>Female
                                    </option>
                                    <option value="other" <?php echo $row['gender'] == 'other' ? 'selected' : ''; ?>>Other
                                    </option>
                                </select>
                            </div>

                            <!-- Age -->
                            <div class="mb-3">
                                <label for="age" class="form-label"><strong>Age</strong></label>
                                <input type="text" class="form-control" id="age" name="age"
                                    value="<?php echo $row['age']; ?>" required>
                            </div>

                            <!-- Bio -->
                            <div class="mb-3">
                                <label for="bio" class="form-label"><strong>Bio</strong></label>
                                <textarea class="form-control" id="bio" name="bio"
                                    rows="3"><?php echo $row['bio']; ?></textarea>
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
        <?php
    }
}
?>

<!-- Modal -->
<div class="modal fade" id="update_profile_picture_modal" tabindex="-1" aria-labelledby="update_profile_picture_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="update_profile_picture_modal">Upload your profile picture</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../assets/php_script/upload_user_profile_image.php" method="post" enctype="multipart/form-data">
                    <!-- File input for profile picture -->
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Choose your profile picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" required>
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

<?php
    $sql = "SELECT * FROM user_account WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
?>
            <!-- Modal -->
            <div class="modal fade" id="change_user_password_modal" tabindex="-1" aria-labelledby="change_user_password_modal_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="change_user_password_modal_label">Change Password</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../assets/php_script/change_user_password_script.php" method="post">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                <!-- New Password -->
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                                <!-- Confirm New Password -->
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
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