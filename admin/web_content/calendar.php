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
        <title>Admin: Calendar</title>

        <link rel="stylesheet" href="../../assets/style/admin_style.css">
    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col">
                    <h3 class="p-3 text-center"><i class="fa-solid fa-calendar-week"></i> Event Calendar</h3>
                    <section class="my-2 px-4">
                        <div id="calendar"></div>
                    </section>
                </div>
            </div>
        </div>

        
        <script src="../../assets/script/admin_script.js"></script>

        <script>
            $(document).ready(function () {
                $('#calendar').evoCalendar({
                theme: 'Midnight Blue',
                calendarEvents: [
                    {
                    id: "id01",
                    name: "Customer Name",
                    date: "11/11/2024",
                    description: "Item Purchased",
                    type: 'event'
                    },
                    {
                    id: "id02",
                    name: "Customer Name",
                    date: "11/14/2024",
                    description: "Item Purchased",
                    type: 'event'
                    },
                    {
                    id: "id03",
                    name: "Customer Name",
                    date: "11/20/2024",
                    description: "Item Purchased",
                    type: 'event'
                    }
                ]
                });
            });
        </script>
    </body>
</html>
