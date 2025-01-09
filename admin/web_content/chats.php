<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";

    session_start();
    $_SESSION['role'] = 'admin';
    if (!isset($_SESSION['admin_email'])) {
        header("Location: ../index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: Inbox</title>

        <link rel="stylesheet" href="../../assets/style/admin_style.css">
        <link rel="icon" href="/e_commerce/assets/image/hfa_logo.png" type="image/png">

        <style>
            /* Container holding the messages */
            #message_container {
                height: 75vh;
                display: flex;
                flex-direction: row;
                border: 1px solid #ddd;
                justify-content: flex-end; /* Ensure messages align at the bottom */
            }

            /* User list styling */
            #user_list {
                width: 25%;
                background-color: #f8f9fa;
                border-right: 1px solid #ddd;
                padding: 10px;
                overflow-y: auto;
                height: 100%;
            }

            /* Styling for individual users in the list */
            #user_list div {
                padding: 8px;
                margin-bottom: 10px;
                cursor: pointer;
                border-radius: 5px;
                transition: background-color 0.3s;
            }

            #user_list div:hover {
                background-color: #e9ecef;
            }

            /* User message display area */
            #user_message {
                flex-grow: 1;
                padding: 20px;
                background-color: #fff;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            /* Messages container */
            #messages_container {
                flex-grow: 1;
                background-color: #f1f1f1;
                padding: 10px;
                overflow-y: auto;
                margin-bottom: 20px;
                border-radius: 5px;
                height: 80%;
            }

            /* Input field and send button */
            .input-group {
                display: flex;
                align-items: center;
                padding: 10px;
                border-top: 1px solid #ddd;
            }

            .form-control {
                flex-grow: 1;
                border-radius: 2rem 0 0 2rem;
                padding: 10px;
                border: 1px solid #ddd;
            }

            .input-group button {
                border-radius: 0 2rem 2rem 0;
                background-color:rgb(255, 0, 0);
                color: white;
                border: none;
                cursor: pointer;
                padding: 0.5rem 1rem;
            }

            .input-group button:hover {
                background-color:rgb(179, 0, 0);
            }

            /* Container for the image and name */
            #user_message .p-2 {
                display: flex; /* Use Flexbox to align items horizontally */
                align-items: center; /* Align items vertically centered */
            }

            /* Styling for the image */
            #user_image {
                width: 50px; /* Fixed size for the image, adjust as necessary */
                height: 50px; /* Ensure the height is the same as width for a circle */
                border-radius: 50%; /* Make the image rounded */
                object-fit: cover; /* Ensure the image maintains its aspect ratio */
                margin-right: 10px; /* Add space between the image and name */
            }
            #user_image_list {
                width: 30px; /* Fixed size for the image, adjust as necessary */
                height: 30px; /* Ensure the height is the same as width for a circle */
                border-radius: 50%; /* Make the image rounded */
                object-fit: cover; /* Ensure the image maintains its aspect ratio */
                margin-right: 10px; /* Add space between the image and name */
            }

            /* Styling for the user name */
            #user_message h3 {
                margin: 0;
                font-size: 1.5rem;
            }

            /* Custom scrollbar for the message container and user list */
            #user_list, #messages_container {
                overflow-y: auto; /* Ensure scroll is enabled */
            }

            /* Style the scrollbar */
            #user_list::-webkit-scrollbar, #messages_container::-webkit-scrollbar {
                width: 5px; /* Set the width of the scrollbar */
            }

            /* Style the scrollbar track */
            #user_list::-webkit-scrollbar-track, #messages_container::-webkit-scrollbar-track {
                background: #f1f1f1; /* Light background for the track */
                border-radius: 10px;
            }

            /* Style the scrollbar thumb */
            #user_list::-webkit-scrollbar-thumb, #messages_container::-webkit-scrollbar-thumb {
                background:rgb(255, 0, 0); /* Set a color for the scrollbar thumb */
                border-radius: 10px; /* Rounded edges for the thumb */
            }

            /* Hover effect on scrollbar thumb */
            #user_list::-webkit-scrollbar-thumb:hover, #messages_container::-webkit-scrollbar-thumb:hover {
                background:rgb(199, 6, 6); /* Darker shade on hover */
            }

            #messages_container {
                flex-grow: 1;
                background-color: #f1f1f1;
                padding: 10px;
                overflow-y: auto;
                margin-bottom: 20px;
                border-radius: 5px;
                height: 100%;
                display: flex;
                flex-direction: column; /* Stack messages vertically */
            }
            
            #admin_chat {
                max-width: 60%;
                width: auto;
                background:rgb(250, 224, 224); /* Red for admin */
                padding: 5px;
                border-radius: 1rem;
                margin-bottom: 10px;
                align-self: flex-end; /* Align admin chat to the right */
                margin-left: auto; /* Push admin chat to the right */
                color: #333;
                word-wrap: break-word; /* Ensure long words are wrapped */
                word-break: break-word; /* Break words when necessary */
                overflow-wrap: break-word; /* Break words to fit the container */
            }

            #user_chat {
                max-width: 60%;
                width: auto;
                background:rgb(206, 206, 206); /* Gray for user */
                padding: 5px;
                border-radius: 1rem;
                margin-bottom: 10px;
                align-self: flex-start; /* Align user chat to the left */
                margin-right: auto; /* Push user chat to the left */
                color: #333;
                word-wrap: break-word; /* Ensure long words are wrapped */
                word-break: break-word; /* Break words when necessary */
                overflow-wrap: break-word; /* Break words to fit the container */
            }
        </style>
    </head>
    <body>
        <div id="admin-body">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col">
                    <?php include "../../navigation/admin_header.php"; ?>
                    <h3 class="p-3 text-center"><i class="fa-regular fa-comments"></i> Inbox</h3>
                    <div id="message_container" class="container row">
                        <div id="user_list" class="col-lg-3 border-end">
                            <h5>Users</h5>
                            <?php
                                $sql = "SELECT * FROM user_account";
                                $result = mysqli_query($conn, $sql);

                                if($result) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $user_fullname = $row['full_name'];
                                        $user_profile_picture = $row['profile_picture'];
                                        ?>
                                        <div>
                                            <img id="user_image_list" class="border" src="../../assets/image/profile_picture/<?php echo $user_profile_picture; ?>" alt="User Image">
                                            <?php
                                                echo $row['full_name'];
                                            ?>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                        <div id="user_message" class="col">
                            <div class="p-2">
                                <!-- Image of the user aligned to the left -->
                                <img id="user_image" class="border" src="../../assets/image/profile_picture/<?php echo $user_profile_picture; ?>" alt="User Image">
                                <!-- User's full name next to the image -->
                                <h3><?php echo $user_fullname; ?></h3>
                            </div>
                            <div id="messages_container">
                                <!-- Messages will appear here -->
                                <div id="admin_chat">
                                    admin
                                </div>
                                <div id="user_chat">
                                    us er uqews er us qewer uqes er us er us erqe us er ueqws
                                </div>
                            </div>
                            <div id="chat_input">
                                <form action="" method="post">
                                    <div class="input-group">
                                        <input type="text" class="form-control" autocomplete="off" placeholder="Type your message here">
                                        <button type="submit">
                                            <i class="fa-solid fa-caret-right"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
