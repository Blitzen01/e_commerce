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
        <title>Inbox</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>

        <div class="m-3">
            <div class="container">
                
            </div>
        </div>

        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>

        <script>
            
        </script>
    </body>
</html>