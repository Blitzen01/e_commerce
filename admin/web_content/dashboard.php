<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";

    date_default_timezone_set("Asia/Manila");

    $initialTime = date("F j, Y h:i:s A");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: Dashboard</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">
    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col">
                    <h3 class="p-3 text-center">
                        <i class="fa-solid fa-gauge"></i> Dashboard <br> <span id="currentTime"><?php echo $initialTime; ?></span>
                    </h3>
                    <!-- daily monitoring -->
                    <section class="my-2 px-4">
                        <div class="row">
                            <div class="col-lg-3 col-sm-9 text-center m-1 border border-primary rounded">
                                    <div class="row bg-primary">
                                        <span>Today's Income</span>
                                    </div>
                                    <div class="row">
                                        <h4>0</h4>
                                    </div>
                            </div>

                            <div class="col text-center m-1 border border-info rounded">
                                <div class="row bg-info">
                                    <span>Sales</span>
                                </div>
                                <div class="row">
                                    <h4>0</h4>
                                </div>
                            </div>

                            <div class="col text-center m-1 border border-danger rounded">
                                <div class="row bg-danger">
                                    <span>Pending Order</span>
                                </div>
                                <div class="row">
                                    <h4>0</h4>
                                </div>
                            </div>

                            <div class="col text-center m-1 border border-success rounded">
                                <div class="row bg-success">
                                    <span>Revenue</span>
                                </div>
                                <div class="row">
                                    <h4>0</h4>
                                </div>
                            </div>
                        </div>

                        <!-- graphical presentation -->
                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <!-- Line graph -->
                                <canvas id="line_graph"></canvas>
                            </div>
                            <div class="col-lg-6">
                                <!-- Bar chart -->
                                <canvas id="bar_chart"></canvas>
                            </div>
                        </div>
                    </section>

                    <!-- monthly and yearly monitoring -->
                    <section class="my-2 px-4">
                        <h4 class="text-center pt-5 pb-3">Monthly Monitoring</h4>
                        <div class="row pb-4 text-center">
                            <div class="col border border-primary rounded m-1">
                                <div class="row bg-primary">
                                    <span>Total Bookings</span>
                                </div>
                                <div class="row">
                                    <h4>0</h4>
                                </div>
                            </div>

                            <div class="col border border-info rounded m-1">
                                <div class="row bg-info">
                                    <span>Total Order</span>
                                </div>
                                <div class="row">
                                    <h4>0</h4>
                                </div>
                            </div>

                            <div class="col border border-success rounded m-1">
                                <div class="row bg-success">
                                    <span>Total Income</span>
                                </div>
                                <div class="row">
                                    <h4>0</h4>
                                </div>
                            </div>
                        </div>

                        <h4 class="text-center pt-5 pb-3">Yearly Monitoring</h4>
                        <div class="row pb-4 text-center">
                        <div class="col border border-primary rounded m-1">
                                <div class="row bg-primary">
                                    <span>Total Bookings</span>
                                </div>
                                <div class="row">
                                    <h4>0</h4>
                                </div>
                            </div>

                            <div class="col border border-info rounded m-1">
                                <div class="row bg-info">
                                    <span>Total Order</span>
                                </div>
                                <div class="row">
                                    <h4>0</h4>
                                </div>
                            </div>

                            <div class="col border border-success rounded m-1">
                                <div class="row bg-success">
                                    <span>Total Income</span>
                                </div>
                                <div class="row">
                                    <h4>0</h4>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- satisfaction rating -->
                    <section class="my-2 px-4">
                        <div class="card m-3 ps-3 pe-3 shadow">
                            <h3 class="text-center">SUMMARY OF SATISFACTION RATINGS</h3>
                            <table class="table table-sm nowrap table-striped compact table-hover text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Average Rating</th>
                                        <th>Descriptive Rating</th>
                                        <th>Month</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $select_sql = "SELECT YEAR(date) AS year, MONTH(date) AS month, ROUND(AVG(rating), 2) AS average_rating 
                                                    FROM rating 
                                                    GROUP BY YEAR(date), MONTH(date)
                                                    ORDER BY YEAR(date), MONTH(date);";

                                        $result = $conn->query($select_sql);

                                        if ($result) {
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $averageRating = $row['average_rating'];
                                                    $descriptiveRating = getDescriptiveRating($averageRating);
                                                    $year = $row['year'];
                                                    $month = getMonthName($row['month']); // Convert numeric month to month name
                                                    echo "<tr><td>$averageRating</td><td>$descriptiveRating</td><td>$month $year</td></tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='3'>No ratings found</td></tr>";
                                            }
                                        } else {
                                            echo "Query failed: " . $conn->error;
                                        }

                                        function getDescriptiveRating($averageRating) {
                                            if ($averageRating >= 4.5) {
                                                return "HIGHLY SATISFIED";
                                            } elseif ($averageRating >= 3.5) {
                                                return "SATISFIED";
                                            } elseif ($averageRating >= 2.5) {
                                                return "NEUTRAL";
                                            } elseif ($averageRating >= 1.5) {
                                                return "DISSATISFIED";
                                            } else {
                                                return "HIGHLY DISSATISFIED";
                                            }
                                        }

                                        function getMonthName($monthNumber) {
                                            return date("F", mktime(0, 0, 0, $monthNumber, 1)); // Convert month number to month name
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="m-5">
                            <table id="satisfactionRating" class="table table-sm nowrap table-striped compact table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Subject</th>
                                        <th>Ratings</th>
                                        <th>Comments</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM rating";
                                        $result = mysqli_query($conn, $sql);

                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                // Format the date to "Month Day, Year"
                                                $formatted_date = date('F j, Y', strtotime($row['date'])); // Month Day, Year

                                                // Format the time to 12-hour format with AM/PM
                                                $formatted_time = date('h:i A', strtotime($row['time'])); // 12-hour time with AM/PM

                                                ?>
                                                <tr>
                                                    <td><?php echo $row['category']; ?></td>
                                                    <td><?php echo $row['subject']; ?></td>
                                                    <td><?php echo $row['rating']; ?></td>
                                                    <td><?php echo $row['comment']; ?></td>
                                                    <td><?php echo $formatted_date; ?></td>
                                                    <td><?php echo $formatted_time; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <script>
            // Line chart configuration
            const lineCtx = document.getElementById('line_graph').getContext('2d');
            const lineData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Sales',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            };

            const lineConfig = {
                type: 'line',
                data: lineData,
            };

            const lineChart = new Chart(lineCtx, lineConfig);

            // Bar chart configuration
            const barCtx = document.getElementById('bar_chart').getContext('2d');
            const barData = {
                labels: ['Category 1', 'Category 2', 'Category 3', 'Category 4'],
                datasets: [{
                    label: 'Revenue',
                    data: [200, 150, 300, 100],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 206, 86)',
                        'rgb(75, 192, 192)'
                    ]
                }]
            };

            const barConfig = {
                type: 'bar',
                data: barData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            const barChart = new Chart(barCtx, barConfig);

            function updateTime() {
                const options = { 
                    timeZone: 'Asia/Manila', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric', 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit', 
                    hour12: true 
                };
                const now = new Date().toLocaleString('en-US', options);
                document.getElementById('currentTime').innerText = now;
            }

            // Update the time every second
            setInterval(updateTime, 1000);

            $(document).ready(function () {
                var table_booking = $('#satisfactionRating').DataTable();
            });
        </script>
    </body>
</html>