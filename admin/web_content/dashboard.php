<?php
    include "../../assets/cdn/cdn_links.php";

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
                                        <th>Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>HIGHLY SATISFIED</td>
                                        <td>4.5</td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>SATISFIED</td>
                                        <td>3.5</td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>NEUTRAL</td>
                                        <td>2.5</td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>DISSATISFIED</td>
                                        <td>1.5</td>
                                        <td>2024</td>
                                    </tr>
                                    <tr>
                                        <td>HIGHLY DISSATISFIED</td>
                                        <td>1</td>
                                        <td>2024</td>
                                    </tr>
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
                                    <tr>
                                        <td>Suggestion</td>
                                        <td>Design</td>
                                        <td>4</td>
                                        <td>Make it more simple</td>
                                        <td>11/11/2024</td>
                                        <td>12:03 AM</td>
                                    </tr>
                                    <tr>
                                        <td>Praise</td>
                                        <td>Feedback form</td>
                                        <td>5</td>
                                        <td>It's awesome to see a website that has feedback form</td>
                                        <td>11/11/2024</td>
                                        <td>12:03 AM</td>
                                    </tr>
                                    <tr>
                                        <td>Problem</td>
                                        <td>Feedback Form</td>
                                        <td>4</td>
                                        <td>Is it Required to have an feedback?</td>
                                        <td>11/11/2024</td>
                                        <td>12:03 AM</td>
                                    </tr>
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
        </script>
    </body>
</html>