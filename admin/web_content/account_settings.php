<?php
    include "../../assets/cdn/cdn_links.php";
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
                            <div class="col-lg-3 col-sm-11 text-center">
                                <div class="dropdown">
                                    <div id="square-image-container">
                                        <a class="btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img class="rounded-circle" id="profile_picture" src="../../assets/image/profile_picture/blank_profile_picture.png" alt="" srcset="">
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
                                    <div class="col-lg-5 col-sm-11">
                                        <h5><strong>Name: </h5>
                                    </div>
                                    <div class="col-lg-5 col-sm-11">
                                        <h5><strong>Username: </strong> </h5>
                                    </div>
                                    <div class="col-lg-5 col-sm-11">
                                        <h5><strong>Password: </strong> </h5>
                                        <button class="nav-link text-primary ms-3" data-bs-toggle="modal" data-bs-target="#change_password_modal"><u>change password</u></button>
                                    </div>
                                    <div class="col-lg-5 col-sm-11">
                                        <h5><strong>Email: </strong> </h5>
                                    </div>
                                    <div class="col-lg-5 col-sm-11">
                                        <h5><strong>Contact Number: </strong> </h5>
                                    </div>
                                    <div class="col-lg-5 col-sm-11">
                                        <h5><strong>Birthday: </strong> </h5>
                                    </div>
                                    <div class="col-lg-5 col-sm-11">
                                        <h5><strong>Gender: </strong> </h5>
                                    </div>
                                    <hr class="mx-auto" style="width:80%;">
                                    <h5><strong>Bio: </strong> </h5>
                                    <button class="btn btn-danger w-100 text-light" data-bs-toggle="modal" data-bs-target="#update_profile_information_modal_label">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>


        <script src="../../assets/script/admin_script.js"></script>
    </body>
</html>