<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";

    session_start();
    if (!isset($_SESSION['admin_email'])) {
        header("Location: ../index.php"); // Redirect to the index if not logged in
        exit;
    }

    $email = $_SESSION['admin_email'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: Account Settings</title>
        
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
                                                        <li><a class="btn drop-item" data-bs-toggle="modal" data-bs-target="#update_admin_profile_picture_modal">Update profile picture</a></li>
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
                                                    <h5><strong>Username: </strong> <?php echo $row['username']; ?></h5>
                                                </div>
                                                <div class="col-lg-6 col-sm-11">
                                                    <h5><strong>Password: </strong>
                                                        <?php
                                                            $password = $row['password'];
                                                            echo str_repeat('*', strlen($password));
                                                        ?>
                                                    </h5>
                                                    <small>
                                                        <button class="nav-link text-primary ms-3" data-bs-toggle="modal" data-bs-target="#change_user_password_modal">
                                                                <u>change password</u>
                                                        </button>
                                                    </small>
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

<?php
    $sql = "SELECT * FROM admin_account WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
?>
            <!-- update infos Modal -->
            <div class="modal fade" id="admin_update_profile_information_modal" tabindex="-1" aria-labelledby="update_profile_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="update_profile_label">Update Profile</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../../assets/php_script/update_admin_profile.php" method="post">
                                
                                <!-- Hidden field to pass user ID -->
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">

                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="first_name" class="form-label"><strong>First Name</strong></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $row['first_name']; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="last_name" class="form-label"><strong>Last Name</strong></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $row['last_name']; ?>" required>
                                </div>

                                <!-- Username -->
                                <div class="mb-3">
                                    <label for="username" class="form-label"><strong>Username</strong></label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
                                </div>

                                <!-- Contact Number -->
                                <div class="mb-3">
                                    <label for="contact_number" class="form-label"><strong>Contact Number</strong></label>
                                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $row['contact_number']; ?>" required>
                                </div>

                                <!-- Birthday -->
                                <div class="mb-3">
                                    <label for="birthday" class="form-label"><strong>Birthday</strong></label>
                                    <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $row['birthday']; ?>" required>
                                </div>

                                <!-- Gender -->
                                <div class="mb-3">
                                    <label for="gender" class="form-label"><strong>Gender</strong></label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="male" <?php echo $row['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                        <option value="female" <?php echo $row['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                        <option value="other" <?php echo $row['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>

                                <!-- Bio -->
                                <div class="mb-3">
                                    <label for="bio" class="form-label"><strong>Bio</strong></label>
                                    <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo $row['bio']; ?></textarea>
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

<?php
    $sql = "SELECT * FROM admin_account WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
?>
            <!-- change password Modal -->
            <div class="modal fade" id="change_user_password_modal" tabindex="-1" aria-labelledby="change_user_password_modal_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="change_user_password_modal_label">Change Password</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../../assets/php_script/change_admin_password_script.php" method="post">
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

<!-- upload profile picture Modal -->
<div class="modal fade" id="update_admin_profile_picture_modal" tabindex="-1" aria-labelledby="update_admin_profile_picture_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="update_profile_picture_modal">Upload your profile picture</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../assets/php_script/upload_admin_profile_image.php" method="post" enctype="multipart/form-data">
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