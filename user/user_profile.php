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
        .card:hover {
            transform: scale(1.02);
            transition: 0.3s;
        }
    </style>
</head>

<body>
    <?php include "../navigation/user_nav.php"; ?>
    <?php include "chat.php"; ?>

    <div class="m-3">
        <div class="container">
            <h3 class="p-3 text-center"><i class="fa-solid fa-user"></i> Account Settings</h3>
            <!-- account settings display -->
            <section class="my-2">
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
            <!-- bookings display -->
            <section class="my-2 px-4">
                <div class="row text-center">
                    <div class="col">
                        <button class="btn btn-danger w-100 border-0 rounded-0"
                            onclick="showTable('booking', 'booking_transaction', 'declined_booking')">Booking</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-dark w-100 border-0 rounded-0"
                            onclick="showTable('declined_booking', 'booking', 'booking_transaction')">Declined</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-dark w-100 border-0 rounded-0"
                            onclick="showTable('booking_transaction', 'booking', 'declined_booking')">Transactions</button>
                    </div>
                </div>

                <!-- booking layout -->
                <div id="booking" class="container my-4">
                    <?php
                    // Query for booked data
                    $booked = "SELECT * FROM booked WHERE email ='$email'";
                    $result = mysqli_query($conn, $booked);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $formattedDate = date('m/d/Y', strtotime($row['date'])); // Format date as MM/DD/YYYY
                            $formattedTime = date('h:i A', strtotime($row['time'])); // Format time as 12-hour with AM/PM
                            ?>
                            <!-- Booking Card -->
                            <div class="card shadow-sm mb-3">
                                <div class="row g-0 align-items-center">
                                    <div class="col-12">
                                        <div class="card-body">
                                            <h5 class="card-title text-truncate"><?php echo $row['type_of_booking']; ?></h5>
                                            <p class="card-text mb-1">Kind of Booking: <?php echo $row['kind_of_booking']; ?></p>
                                            <p class="card-text mb-1">Mode of Booking: <?php echo $row['mob']; ?></p>
                                            <p class="card-text mb-1">Price: PHP <?php echo number_format($row['price'], 2); ?></p>
                                            <p class="card-text mb-1">Time: <?php echo $formattedTime; ?></p>
                                            <p class="card-text mb-1">Date: <?php echo $formattedDate; ?></p>
                                            <p class="card-text mb-1">Remarks: <?php echo $row['remarks']; ?></p>
                                            <p class="card-text mb-0">
                                                Status: 
                                                <span class="badge bg-warning">
                                                    On Hold
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }

                    // Query for booking data
                    $booking = "SELECT * FROM booking WHERE email ='$email'";
                    $result1 = mysqli_query($conn, $booking);

                    if ($result1) {
                        while ($row = mysqli_fetch_assoc($result1)) {
                            $formattedDate = date('m/d/Y', strtotime($row['date'])); // Format date as MM/DD/YYYY
                            $formattedTime = date('h:i A', strtotime($row['time'])); // Format time as 12-hour with AM/PM
                            ?>
                            <!-- Booking Card -->
                            <div class="card shadow-sm mb-3">
                                <div class="row g-0 align-items-center">
                                    <div class="col-12">
                                        <div class="card-body">
                                            <h5 class="card-title text-truncate"><?php echo $row['type_of_booking']; ?></h5>
                                            <p class="card-text mb-1">Kind of Booking: <?php echo $row['kind_of_booking']; ?></p>
                                            <p class="card-text mb-1">Mode of Booking: <?php echo $row['mob']; ?></p>
                                            <p class="card-text mb-1">Price: PHP <?php echo number_format($row['price'], 2); ?></p>
                                            <p class="card-text mb-1">Time: <?php echo $formattedTime; ?></p>
                                            <p class="card-text mb-1">Date: <?php echo $formattedDate; ?></p>
                                            <p class="card-text mb-1">Remarks: <?php echo $row['remarks']; ?></p>
                                            <p class="card-text mb-0">
                                                Status: 
                                                <span class="badge bg-success">
                                                    <?php echo ucfirst($row['status']); ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>

                <!-- Declined Transactions -->
                <div id="declined_booking" style="display: none;" class="container my-4">
                    <?php
                    // Query for declined transactions
                    $declined_query = "SELECT * FROM transaction_history WHERE email ='$email' AND status LIKE '%Declined%'";
                    $result = mysqli_query($conn, $declined_query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $formattedDate = date('m/d/Y', strtotime($row['transaction_date'])); // Format date as MM/DD/YYYY
                            $formattedTime = date('h:i A', strtotime($row['time'])); // Format time as 12-hour with AM/PM
                            ?>

                            <!-- Responsive Declined Booking Card -->
                            <div class="card shadow-sm mb-3">
                                <div class="row g-0 align-items-center">
                                    <!-- Booking Details Section -->
                                    <div class="col-12">
                                        <div class="card-body">
                                            <h5 class="card-title text-truncate">Booking Type: <?php echo $row['type_of_booking']; ?></h5>
                                            <p class="card-text mb-1">Kind of Booking: <?php echo $row['kind_of_booking']; ?></p>
                                            <p class="card-text mb-1">Mode of Booking: <?php echo $row['mob']; ?></p>
                                            <p class="card-text mb-1">Price: PHP <?php echo number_format($row['total_amount'], 2); ?></p>
                                            <p class="card-text mb-1">Time: <?php echo $formattedTime; ?></p>
                                            <p class="card-text mb-1">Date: <?php echo $formattedDate; ?></p>
                                            <p class="card-text mb-1">
                                                Status: 
                                                <span class="badge bg-danger">
                                                    <?php echo ucfirst($row['status']); ?>
                                                </span>
                                            </p>
                                            <p class="card-text">Remarks: <?php echo $row['remarks']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>


                <!-- transaction booking layout -->
                <div id="booking_transaction" style="display: none;" class="container my-4">
                    <?php
                    $transaction = "SELECT * FROM transaction_history WHERE email ='$email' AND status = 'Booking Finished'";
                    $result = mysqli_query($conn, $transaction);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $formattedDate = date('m/d/Y', strtotime($row['transaction_date'])); // Format date as MM/DD/YYYY
                            $formattedTime = date('h:i A', strtotime($row['time'])); // Format time as 12-hour with AM/PM
                            ?>

                            <!-- Responsive Booking Card -->
                            <div class="card shadow-sm mb-3">
                                <div class="row g-0 align-items-center">
                                    <!-- Booking Details Section -->
                                    <div class="col-12">
                                        <div class="card-body">
                                            <h5 class="card-title text-truncate">Booking Type: <?php echo $row['type_of_booking']; ?></h5>
                                            <p class="card-text mb-1">Kind of Booking: <?php echo $row['kind_of_booking']; ?></p>
                                            <p class="card-text mb-1">Mode of Booking: <?php echo $row['mob']; ?></p>
                                            <p class="card-text mb-1">Price: PHP <?php echo number_format($row['total_amount'], 2); ?></p>
                                            <p class="card-text mb-1">Time: <?php echo $formattedTime; ?></p>
                                            <p class="card-text mb-1">Date: <?php echo $formattedDate; ?></p>
                                            <p class="card-text mb-1">
                                                Status: 
                                                <span class="badge bg-success">
                                                    <?php echo ucfirst($row['status']); ?>
                                                </span>
                                            </p>
                                            <p class="card-text">Remarks: <?php echo $row['remarks']; ?></p>

                                            <!-- Review Button -->
                                            <div class="text-end">
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#review_booking_<?php echo $row['id']; ?>">Review</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Review Modal -->
                            <div class="modal fade" id="review_booking_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="reviewBookingLabel_<?php echo $row['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="../assets/php_script/submit_booking_review.php" method="POST" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="reviewBookingLabel_<?php echo $row['id']; ?>">Submit Your Booking Review</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                                <input type="hidden" name="booking_reference" value="<?php echo $row['type_of_booking']; ?>">
                                                <!-- Picture Upload -->
                                                <div class="mb-3">
                                                    <label for="picture_<?php echo $row['id']; ?>" class="form-label">Upload Picture</label>
                                                    <input type="file" class="form-control" id="picture_<?php echo $row['id']; ?>" name="picture" accept="image/*" required>
                                                </div>

                                                <!-- Review Remarks -->
                                                <div class="mb-3">
                                                    <label for="remarks_<?php echo $row['id']; ?>" class="form-label">Your Review</label>
                                                    <textarea class="form-control" id="remarks_<?php echo $row['id']; ?>" name="remarks" rows="4" placeholder="Write your review here..." required></textarea>
                                                </div>

                                                <!-- Star Rating -->
                                                <div class="mb-3">
                                                    <label class="form-label">Your Rating</label>
                                                    <div id="starRating_<?php echo $row['id']; ?>" class="d-flex">
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <input type="radio" class="btn-check" name="rating" id="star_<?php echo $row['id']; ?>_<?php echo $i; ?>" value="<?php echo $i; ?>" required>
                                                            <label class="btn btn-outline-warning star-label" for="star_<?php echo $row['id']; ?>_<?php echo $i; ?>" data-value="<?php echo $i; ?>">
                                                                &#9733;
                                                            </label>
                                                        <?php endfor; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit Review</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </section>

            <br>

            <h3 class="p-3 text-center" id="profile_order_view"><i class="fa-solid fa-shop"></i> Orders</h3>
            <!-- orders display -->
            <section class="my-2 px-4">
                <div class="row text-center">
                    <div class="col">
                        <button class="btn btn-danger w-100 border-0 rounded-0"
                            onclick="showTable('order', 'declined', 'order_transaction')">Orders</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-dark w-100 border-0 rounded-0"
                            onclick="showTable('declined', 'order', 'order_transaction')">Declined</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-dark w-100 border-0 rounded-0"
                            onclick="showTable('order_transaction', 'order', 'declined')">Transactions</button>
                    </div>
                </div>

                <!-- Orders Table -->
                <div id="order" class="container my-4">
                    <?php
                    // Query for order_booking
                    $order_booking = "SELECT * FROM order_booking WHERE email ='$email'";
                    $result = mysqli_query($conn, $order_booking);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Start the card layout for each order
                            ?>
                            <!-- Order Card -->
                            <div class="card shadow-sm mb-3">
                                <div class="row g-0 align-items-center">
                                    <div class="col-12">
                                        <div class="card-body">
                                            <h5 class="card-title text-truncate"><?php echo $row['item']; ?></h5>
                                            <p class="card-text mb-1">Quantity: <?php echo $row['quantity']; ?></p>
                                            <p class="card-text mb-1">Price: PHP <?php echo number_format($row['price'], 2); ?></p>
                                            <p class="card-text mb-1">Payment: <?php echo strtoupper($row['mop']); ?></p>
                                            <p class="card-text mb-0">
                                                Status: 
                                                <span class="badge bg-<?php echo strtolower('On Hold') == 'on hold' ? 'warning' : 'success'; ?>">
                                                    <?php echo 'On Hold'; ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }

                    // Query for order_booked
                    $order_booked = "SELECT * FROM order_booked WHERE email ='$email'";
                    $result = mysqli_query($conn, $order_booked);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <!-- Order Card -->
                            <div class="card shadow-sm mb-3">
                                <div class="row g-0 align-items-center">
                                    <div class="col-12">
                                        <div class="card-body">
                                            <h5 class="card-title text-truncate"><?php echo $row['item']; ?></h5>
                                            <p class="card-text mb-1">Quantity: <?php echo $row['quantity']; ?></p>
                                            <p class="card-text mb-1">Price: PHP <?php echo number_format($row['price'], 2); ?></p>
                                            <p class="card-text mb-1">Payment: <?php echo strtoupper($row['mop']); ?></p>
                                            <p class="card-text mb-0">
                                                Status: 
                                                <span class="badge bg-success">
                                                    <?php echo ucfirst($row['status']); ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>

                <!-- Declined Transactions -->
                <div id="declined" style="display: none;" class="container my-4">
                    <?php
                    $declined_query = "SELECT * FROM order_transaction_history WHERE email ='$email' AND status LIKE '%Declined%'";
                    $result = mysqli_query($conn, $declined_query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $imgPath = "";
                            $productSql = "SELECT * FROM products";
                            $productResult = mysqli_query($conn, $productSql);

                            // Fetch product image
                            if ($productResult) {
                                while ($productRow = mysqli_fetch_assoc($productResult)) {
                                    if ($productRow['product_name'] == $row['item']) {
                                        $imgPath = "../assets/image/product_image/" . $productRow['product_image'];
                                    }
                                }
                            }

                            // Fetch package image
                            $packageSql = "SELECT * FROM package";
                            $packageResult = mysqli_query($conn, $packageSql);

                            if ($packageResult) {
                                while ($packageRow = mysqli_fetch_assoc($packageResult)) {
                                    if ($packageRow['package_name'] == $row['item']) {
                                        $imgPath = "../assets/image/package_image/" . $packageRow['package_image'];
                                    }
                                }
                            }
                            ?>

                            <!-- Responsive Product Card -->
                            <div class="card shadow-sm mb-3">
                                <div class="row g-0 align-items-center">
                                    <!-- Image Section -->
                                    <div class="col-4 col-sm-3">
                                        <img src="<?php echo $imgPath; ?>" alt="Product Image" class="img-fluid rounded-start">
                                    </div>

                                    <!-- Details Section -->
                                    <div class="col-8 col-sm-6">
                                        <div class="card-body">
                                            <h5 class="card-title text-truncate"><?php echo $row['item']; ?></h5>
                                            <p class="card-text mb-1">Quantity: <?php echo $row['quantity']; ?></p>
                                            <p class="card-text mb-1">Total: PHP <?php echo number_format($row['total_amount'], 2); ?></p>
                                            <p class="card-text mb-1">Payment: <?php echo strtoupper($row['mop']); ?></p>
                                            <p class="card-text mb-0">
                                                Status: 
                                                <span class="badge bg-danger"><?php echo ucfirst($row['status']); ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>

                <!-- Transactions Table -->
                <div id="order_transaction" style="display: none;" class="container my-4">
                    <?php
                    $transaction_query = "SELECT * FROM order_transaction_history WHERE email ='$email' AND status = 'Order Finished'";
                    $result = mysqli_query($conn, $transaction_query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $imgPath = "";
                            $productSql = "SELECT * FROM products";
                            $productResult = mysqli_query($conn, $productSql);

                            // Fetch product image
                            if ($productResult) {
                                while ($productRow = mysqli_fetch_assoc($productResult)) {
                                    if ($productRow['product_name'] == $row['item']) {
                                        $imgPath = "../assets/image/product_image/" . $productRow['product_image'];
                                    }
                                }
                            }

                            // Fetch package image
                            $packageSql = "SELECT * FROM package";
                            $packageResult = mysqli_query($conn, $packageSql);

                            if ($packageResult) {
                                while ($packageRow = mysqli_fetch_assoc($packageResult)) {
                                    if ($packageRow['package_name'] == $row['item']) {
                                        $imgPath = "../assets/image/package_image/" . $packageRow['package_image'];
                                    }
                                }
                            }
                            ?>

                            <!-- Responsive Product Card -->
                            <div class="card shadow-sm mb-3">
                                <div class="row g-0 align-items-center">
                                    <!-- Image Section -->
                                    <div class="col-4 col-sm-3">
                                        <img src="<?php echo $imgPath; ?>" alt="Product Image" class="img-fluid rounded-start">
                                    </div>

                                    <!-- Details Section -->
                                    <div class="col-8 col-sm-6">
                                        <div class="card-body">
                                            <h5 class="card-title text-truncate"><?php echo $row['item']; ?></h5>
                                            <p class="card-text mb-1">Quantity: <?php echo $row['quantity']; ?></p>
                                            <p class="card-text mb-1">Total: PHP <?php echo number_format($row['total_amount'], 2); ?></p>
                                            <p class="card-text mb-1">Payment: <?php echo strtoupper($row['mop']); ?></p>
                                            <p class="card-text mb-0">
                                                Status: 
                                                <span class="badge bg-<?php echo strtolower($row['status']) == 'order finished' ? 'success' : 'warning'; ?>">
                                                    <?php echo ucfirst($row['status']); ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Review Button Section (Similar to Booking Layout) -->
                                    <div class="text-end">
                                        <button class="btn btn-success btn-sm m-2" data-bs-toggle="modal" data-bs-target="#review_order_<?php echo $row['id']; ?>">Review</button>
                                    </div>
                                </div>
                            </div>

                            <!-- order review Modal -->
                            <div class="modal fade" id="review_order_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="reviewOrderLabel_<?php echo $row['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="../assets/php_script/submit_order_review.php" method="POST" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="reviewOrderLabel_<?php echo $row['id']; ?>">Submit Order Your Review</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" id="item_name" name="item_name" value="<?php echo $row['item']; ?>">
                                                <!-- Picture Upload -->
                                                <div class="mb-3">
                                                    <label for="picture_<?php echo $row['id']; ?>" class="form-label">Upload Picture</label>
                                                    <input type="file" class="form-control" id="picture_<?php echo $row['id']; ?>" name="picture" accept="image/*" required>
                                                </div>

                                                <!-- Review Remarks -->
                                                <div class="mb-3">
                                                    <label for="remarks_<?php echo $row['id']; ?>" class="form-label">Your Review</label>
                                                    <textarea class="form-control" id="remarks_<?php echo $row['id']; ?>" name="remarks" rows="4" placeholder="Write your review here..." required></textarea>
                                                </div>

                                                <!-- Star Rating -->
                                                <div class="mb-3">
                                                    <label class="form-label">Your Rating</label>
                                                    <div id="starRating_<?php echo $row['id']; ?>" class="d-flex">
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <input type="radio" class="btn-check" name="rating" id="star_<?php echo $row['id']; ?>_<?php echo $i; ?>" value="<?php echo $i; ?>" required>
                                                            <label class="btn btn-outline-warning star-label" for="star_<?php echo $row['id']; ?>_<?php echo $i; ?>" data-value="<?php echo $i; ?>">
                                                                &#9733;
                                                            </label>
                                                        <?php endfor; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit Review</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- script for order review -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const starRatingDiv = document.getElementById('starRating_<?php echo $row['id']; ?>');
                                    if (!starRatingDiv) {
                                        console.error('Star rating container not found for ID:', '<?php echo $row['id']; ?>');
                                        return;
                                    }
                                    const stars = starRatingDiv.querySelectorAll('.star-label');

                                    stars.forEach((star, index) => {
                                        star.addEventListener('click', function () {
                                            const value = parseInt(this.getAttribute('data-value'));
                                            stars.forEach((s, i) => {
                                                if (i < value) {
                                                    s.classList.add('btn-warning'); // Add filled color
                                                    s.classList.remove('btn-outline-warning'); // Remove outline
                                                } else {
                                                    s.classList.add('btn-outline-warning'); // Add outline
                                                    s.classList.remove('btn-warning'); // Remove filled color
                                                }
                                            });
                                        });
                                    });
                                });
                            </script>
                            <?php
                        }
                    }
                    ?>
                </div>
            </section>

        </div>
    </div>

    <hr class="mx-5 mt-5 mb-3">

    <?php include "../navigation/user_footer.php"; ?>

    <script defer src="../assets/script/user_script.js"></script>

    <script>
        function showTable(showId, ...hideIds) {
            // Show the specified table
            document.getElementById(showId).style.display = '';

            // Hide all other tables
            hideIds.forEach(hideId => {
                document.getElementById(hideId).style.display = 'none';
            });
        }

        const now = new Date();
        const offset = 8; // PHT is UTC+8
        const philippineTime = new Date(now.getTime() + offset * 60 * 60 * 1000);

        // Format the date to YYYY-MM-DD
        const today = philippineTime.toISOString().split('T')[0];

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
        <!-- update user profile Modal -->
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

<!-- update user profile picture Modal -->
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
            <!-- change user password Modal -->
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