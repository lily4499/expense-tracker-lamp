<?php 
// Include the database connection
include 'db.php';

// Query to get the total income and total expenses
$incomeQuery = "SELECT SUM(amount) AS total FROM transactions WHERE type='income'";
$expenseQuery = "SELECT SUM(amount) AS total FROM transactions WHERE type='expense'";

$incomeResult = $conn->query($incomeQuery);
$expenseResult = $conn->query($expenseQuery);

// Fetch the totals
$income = $incomeResult->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
$expense = $expenseResult->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Close the database connection
$conn = null; // For PDO, you close the connection by setting it to null
?>
<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->
</head>
<body>
    <h1>Income vs Expense Report</h1>
    <canvas id="reportChart" width="400" height="200"></canvas>
    <script>
        // Get data from PHP
        const income = <?php echo $income; ?>;
        const expense = <?php echo $expense; ?>;

        // Create the bar chart
        const ctx = document.getElementById('reportChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar', // Type of chart
            data: {
                labels: ['Income', 'Expense'], // Labels for the chart
                datasets: [{
                    label: 'Amount ($)',
                    data: [income, expense], // Data for the chart
                    backgroundColor: ['#4caf50', '#f44336'], // Colors for bars
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: 'Income vs Expense'
                    }
                }
            }
        });
    </script>
</body>
</html>


