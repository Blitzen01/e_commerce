<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";

    session_start();
    if (!isset($_SESSION['admin_email'])) {
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
        <link rel="icon" href="/e_commerce/assets/image/hfa_logo.png" type="image/png">

        <!-- Add the evo-calendar.css for styling -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.midnight-blue.min.css">
    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col">
                    <?php include "../../navigation/admin_header.php"; ?>
                    <h3 class="p-3 text-center"><i class="fa-solid fa-calendar-week"></i> Event Calendar</h3>
                    <section class="my-2 px-4">
                        <div id="calendar"></div>
                    </section>
                </div>
            </div>
        </div>

        
        <script src="../../assets/script/admin_script.js"></script>
        
        <!-- Add the evo-calendar.js for.. obviously, functionality! -->
        <script defer src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#calendar').evoCalendar({
                    theme: 'Midnight Blue',
                    calendarEvents: [
                    <?php
                        $sql = "SELECT * FROM booking";
                        $result = mysqli_query($conn, $sql);

                        if($result) {
                            while($row = mysqli_fetch_assoc($result)){
                    ?>
                            {
                                id: "booking<?php echo $row['id']; ?>",
                                name: "<?php echo $row['name']; ?>",
                                date: "<?php echo $row['date']; ?>",
                                description: "<h4>Type of booking: <?php echo $row['type_of_booking'];?></h4> <br> Email: <?php echo $row['email'];?> <br> Address: <?php echo $row['address'];?> <br> Contact Number: <?php echo $row['contact_number'];?> <br> Time: <?php echo $row['time'];?>",
                                type: 'event',
                            },
                    <?php
                            }
                        }
                    ?>
                    <?php
                        $sql = "SELECT * FROM booked";
                        $result = mysqli_query($conn, $sql);

                        if($result) {
                            while($row = mysqli_fetch_assoc($result)){
                    ?>
                            {
                                id: "booked<?php echo $row['id']; ?>",
                                name: "<?php echo $row['name']; ?>",
                                date: "<?php echo $row['date']; ?>",
                                description: "<h4>Type of booking: <?php echo $row['type_of_booking'];?></h4> <br> Email: <?php echo $row['email'];?> <br> Address: <?php echo $row['address'];?> <br> Contact Number: <?php echo $row['contact_number'];?> <br> Time: <?php echo $row['time'];?>",
                                type: 'holiday',
                            },
                    <?php
                            }
                        }
                    ?>
                    ]
                });
            });
        </script>
    </body>
</html>
