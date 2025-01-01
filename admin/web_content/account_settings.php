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
        <title>Admin: Account Settings</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">

    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col">
                    <h3 class="p-3 text-center"><i class="fa-solid fa-user"></i> Account Settings</h3>
                    <section class="my-2 px-4">
                        <div class="row">
                            <?php
                                $sql = "SELECT * FROM admin_account WHERE email = '$email'";
                                $result = mysqli_query($conn, $sql);

                                if($result) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <div class="col-lg-3 col-sm-11 text-center">
                                            <div class="dropdown">
                                                <div id="square-image-container">
                                                    <a class="btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img 
                                                        class="rounded-circle" 
                                                        id="profile_picture" 
                                                        src="../../assets/image/profile_picture/<?php echo !empty($row["profile_picture"]) ? $row["profile_picture"] : "blank_profile_picture.png"; ?>" 
                                                        alt="Profile Picture" 
                                                        srcset="">
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
                                                    <h5><strong>Name: </strong> <?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?></h5>
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
                                                <hr class="mx-auto" style="width:80%;">
                                                <h5><strong>Bio: </strong> <?php echo $row['bio']; ?></h5>
                                                <button class="btn btn-danger w-100 text-light" data-bs-toggle="modal" data-bs-target="#admin_update_profile_information_modal">Update Profile</button>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>


        <script src="../../assets/script/admin_script.js"></script>
    </body>
</html>