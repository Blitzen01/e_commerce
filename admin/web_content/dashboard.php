<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";
    include "../../assets/php_script/dashboard_monitoring_script.php";
    
    session_start();
    if (!isset($_SESSION['admin_email'])) {
        header("Location: ../index.php"); // Redirect to the index if not logged in
        exit;
    }

    date_default_timezone_set("Asia/Manila");

    $initialTime = date("F j, Y h:i:s A");

    // Initialize data arrays
    $bookings = [];
    $sales = [];

    // Fetch bookings data
    $bookingsQuery = "
        SELECT type_of_booking, COUNT(*) AS booking_count
        FROM transaction_history
        WHERE WEEKOFYEAR(transaction_date) = WEEKOFYEAR(NOW())
        GROUP BY type_of_booking
        ORDER BY booking_count 
        LIMIT 5
    ";
    $bookingsResult = $conn->query($bookingsQuery);
    while ($row = $bookingsResult->fetch_assoc()) {
        $bookings[] = $row;
    }

    // Fetch sales data
    $salesQuery = "
        SELECT item, SUM(quantity) AS total_sold
        FROM order_transaction_history
        WHERE WEEKOFYEAR(transaction_date) = WEEKOFYEAR(NOW())
        GROUP BY item
        ORDER BY total_sold
        LIMIT 5
    ";
    $salesResult = $conn->query($salesQuery);
    while ($row = $salesResult->fetch_assoc()) {
        $sales[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: Dashboard</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">
        <link rel="icon" href="/e_commerce/assets/image/hfa_logo.png" type="image/png">

        <style>
            #downloadCsvButtonSummary, #downloadCSVButtonReport {
                background-color:rgb(24, 180, 219); /* Blue */
                color: white;
                border-radius: 0.25rem;
            }
            #downloadExcelButtonSummary, #downloadExcelButtonReport {
                background-color:rgb(42, 196, 78); /* Green */
                color: white;
                border-radius: 0.25rem;
            }
            #downloadPdfButtonSummary, #downloadPdfButtonReport {
                background-color:rgb(207, 83, 96) !important; /* Red */
                color: white;
                border-radius: 0.25rem;
            }
        </style>
    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col">
                    <?php include "../../navigation/admin_header.php"; ?>
                    <h3 class="p-3 text-center">
                        <i class="fa-solid fa-gauge"></i> Dashboard <br> <span id="currentTime"><?php echo $initialTime; ?></span>
                    </h3>

                    <!-- generate reports -->
                    <div class="mx-3">
                        <table id="generate_reports" class="table table-sm nowrap table-striped compact table-hover text-center" style="display: none;">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Weekly Monitoring</th>
                                    <th>Monthly Monitoring Order</th>
                                    <th>Yearly Monitory</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Order</td>
                                    <td><?php echo $weeklyTotalOrder; ?></td>
                                    <td><?php echo $monthlyTotalOrder; ?></td>
                                    <td><?php echo $yearlyTotalOrder; ?></td>
                                </tr>
                                <tr>
                                    <td>Booking</td>
                                    <td><?php echo $weeklyTotalBooking; ?></td>
                                    <td><?php echo $monthlyTotalBooking; ?></td>
                                    <td><?php echo $yearlyTotalBooking; ?></td>
                                </tr>
                                <tr>
                                    <td>Income</td>
                                    <td><?php echo $weeklyTotalIncome; ?></td>
                                    <td><?php echo $monthlyIncome; ?></td>
                                    <td><?php echo $yearlyIncome; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- daily monitoring -->
                    <section class="my-2 px-4">
                        <h4 class="text-center pt-2 pb-3">Weekly Monitoring</h4>
                        <div class="row">
                            <div class="col text-center m-1 border border-primary rounded">
                                    <div class="row bg-primary">
                                        <span>Total Booking</span>
                                    </div>
                                    <div class="row">
                                        <h4><?php echo $weeklyTotalBooking; ?></h4>
                                    </div>
                            </div>

                            <div class="col text-center m-1 border border-danger rounded">
                                <div class="row bg-danger">
                                    <span>Pending Booking</span>
                                </div>
                                <div class="row">
                                    <h4><?php echo $weeklyTotalPendingBooking; ?></h4>
                                </div>
                            </div>

                            <div class="col text-center m-1 border border-info rounded">
                                <div class="row bg-info">
                                    <span>Total Order</span>
                                </div>
                                <div class="row">
                                    <h4><?php echo $weeklyTotalOrder; ?></h4>
                                </div>
                            </div>

                            <div class="col text-center m-1 border border-danger rounded">
                                <div class="row bg-danger">
                                    <span>Pending Order</span>
                                </div>
                                <div class="row">
                                    <h4><?php echo $weeklyTotalPendingOrder; ?></h4>
                                </div>
                            </div>

                            <div class="col text-center m-1 border border-success rounded">
                                <div class="row bg-success">
                                    <span>Total Income</span>
                                </div>
                                <div class="row">
                                    <h4>&#8369; <?php echo number_format($weeklyTotalIncome, 2); ?></h4>
                                </div>
                            </div>
                        </div>

                        <!-- graphical presentation -->
                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <canvas id="line_graph"></canvas>
                            </div>
                            <div class="col-lg-6">
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
                                    <h4><?php echo $monthlyTotalBooking; ?></h4>
                                </div>
                            </div>

                            <div class="col border border-info rounded m-1">
                                <div class="row bg-info">
                                    <span>Total Order</span>
                                </div>
                                <div class="row">
                                    <h4><?php echo $monthlyTotalOrder; ?></h4>
                                </div>
                            </div>

                            <div class="col border border-success rounded m-1">
                                <div class="row bg-success">
                                    <span>Total Income</span>
                                </div>
                                <div class="row">
                                    <h4>&#8369; <?php echo number_format($monthlyIncome, 2); ?></h4>
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
                                    <h4><?php echo $yearlyTotalBooking; ?></h4>
                                </div>
                            </div>

                            <div class="col border border-info rounded m-1">
                                <div class="row bg-info">
                                    <span>Total Order</span>
                                </div>
                                <div class="row">
                                    <h4><?php echo $yearlyTotalOrder; ?></h4>
                                </div>
                            </div>

                            <div class="col border border-success rounded m-1">
                                <div class="row bg-success">
                                    <span>Total Income</span>
                                </div>
                                <div class="row">
                                    <h4>&#8369; <?php echo number_format($yearlyIncome, 2); ?></h4>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

        <script>
            // Keep updating time
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

            setInterval(updateTime, 1000);

            $(document).ready(function () {
                var currentDate = new Date().toLocaleDateString();  // Get current date for title

                $('#satisfactionRating').DataTable({
                    dom: 'Bfrtip', // Buttons on top of the table
                    buttons: [
                        {
                            extend: 'csv',
                            title: `Satisfaction Rating - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadCsvButtonSummary'); // Set unique ID for CSV button
                                $(node).addClass('btn btn-primary rounded'); // Blue button for CSV
                            },
                        },
                        {
                            extend: 'excel',
                            title: `Satisfaction Rating - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadExcelButtonSummary'); // Set unique ID for Excel button
                                $(node).addClass('btn btn-success rounded'); // Green button for Excel
                            },
                        },
                        {
                            extend: 'pdf',
                            title: `Satisfaction Rating - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadPdfButtonSummary'); // Set unique ID for PDF button
                                $(node).addClass('btn btn-danger rounded'); // Red button for PDF
                            },
                            orientation: 'landscape', // Horizontal layout
                            pageSize: 'A4', // Page size
                            customize: function (doc) {
                                doc.styles.tableHeader = {
                                    bold: true,
                                    fontSize: 12,
                                    color: 'black',
                                    alignment: 'center'
                                };
                            }
                        }
                    ],
                    autoWidth: false, // Prevent automatic width calculation
                    initComplete: function () {
                        var tableWidth = this.api().table().node().offsetWidth;
                        var containerWidth = $(this.api().table().container()).parent().width();
                        if (tableWidth > containerWidth) {
                            this.api().settings()[0].oScroll.sX = '100%';
                            this.api().draw();
                        }
                    }
                });
            });

            $(document).ready(function () {
                var currentDate = new Date().toLocaleDateString();  // Get current date for title

                $('#generate_reports').DataTable({
                    dom: 'Bfrtip', // Buttons on top of the table
                    buttons: [
                        {
                            extend: 'csv',
                            title: `Reports - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadCSVButtonReport'); // Set unique ID for CSV button
                                $(node).addClass('btn btn-primary rounded'); // Blue button for CSV
                            },
                        },
                        {
                            extend: 'excel',
                            title: `Reports - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadExcelButtonReport'); // Set unique ID for Excel button
                                $(node).addClass('btn btn-success rounded'); // Green button for Excel
                            },
                        },
                        {
                            extend: 'pdf',
                            title: `Reports - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadPdfButtonReport'); // Set unique ID for PDF button
                                $(node).addClass('btn btn-danger rounded'); // Red button for PDF
                            },
                            orientation: 'landscape', // Horizontal layout
                            pageSize: 'A4', // Page size
                            customize: function (doc) {
                                doc.styles.tableHeader = {
                                    bold: true,
                                    fontSize: 12,
                                    color: 'black',
                                    alignment: 'center'
                                };
                            }
                        }
                    ],
                    autoWidth: false, // Prevent automatic width calculation
                    initComplete: function () {
                        var tableWidth = this.api().table().node().offsetWidth;
                        var containerWidth = $(this.api().table().container()).parent().width();
                        if (tableWidth > containerWidth) {
                            this.api().settings()[0].oScroll.sX = '100%';
                            this.api().draw();
                        }
                    },
                    paging: false,  // Disable pagination
                    searching: false,  // Disable search bar
                    info: false  // Disable "Showing 1 to 3 of 3 entries" text
                });
            });

            // Data from PHP
            const bookings = <?php echo json_encode($bookings); ?>;
            const sales = <?php echo json_encode($sales); ?>;

            // Line Chart Configuration for Bookings
            const lineCtx = document.getElementById('line_graph').getContext('2d');
            const lineChart = new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: bookings.map(b => b.type_of_booking), // Booking types
                    datasets: [{
                        label: 'Top Bookings',
                        data: bookings.map(b => b.booking_count), // Booking counts
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                }
            });

            const barCtx = document.getElementById('bar_chart').getContext('2d');
            const barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: sales.map(s => s.item), // Item names (used for tooltip only)
                    datasets: [{
                        label: 'Top Sales',
                        data: sales.map(s => s.total_sold), // Total sold
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 206, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(153, 102, 255)'
                        ]
                    }]
                },
                options: {
                    scales: {
                        x: {
                            ticks: {
                                display: false // Hides labels on the x-axis
                            },
                            grid: {
                                display: false // Optionally hide grid lines on the x-axis
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: true // Optional: Display or hide the legend
                        },
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItems) {
                                    // Display the full item name in the tooltip
                                    const index = tooltipItems[0].dataIndex;
                                    return sales[index].item;
                                },
                                label: function(context) {
                                    // Display the sales data in the tooltip
                                    return `Sold: ${context.raw}`;
                                }
                            }
                        }
                    }
                }
            });

        </script>
    </body>
</html>