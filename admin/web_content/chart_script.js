async function fetchChartData() {
    try {
        const response = await fetch('chart_data.php'); // PHP endpoint
        const data = await response.json();

        const { bookings, sales } = data;

        // Update Line Chart (Bookings)
        lineChart.data.labels = bookings.map(b => b.type_of_booking); // Update labels with booking types
        lineChart.data.datasets[0].data = bookings.map(b => b.booking_count); // Update data with booking counts
        lineChart.update();

        // Update Bar Chart (Sales)
        barChart.data.labels = sales.map(s => s.item); // Update labels with item names
        barChart.data.datasets[0].data = sales.map(s => s.total_sold); // Update data with total sold
        barChart.update();

    } catch (error) {
        console.error("Error fetching chart data:", error);
    }
}

// Run fetchChartData on page load
fetchChartData();