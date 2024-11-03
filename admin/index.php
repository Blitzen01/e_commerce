<?php
    include "../assets/cdn/cdn_links.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/admin_style.css">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="web_content/calendar.php" method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="admin_username" id="admin_username" placeholder="Username or Email" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="admin_password" id="admin_password" placeholder="Password" autocomplete="off">
                            <a href="" class="nav-link text-primary">Forgot password?</a>
                        </div>
                        <div class="mb-3 mx-5">
                            <button class="btn btn-danger w-100" type="submit">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>