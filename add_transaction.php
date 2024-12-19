<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize POST data
    $transaction_date = $_POST['date'] ?? ''; // 'date' matches the input field name
    $type = $_POST['type'] ?? '';
    $category = $_POST['category'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $description = $_POST['description'] ?? null;

    // Validate required inputs
    if (empty($transaction_date) || empty($type) || empty($category) || empty($amount)) {
        die("All fields except description are required.");
    }

    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare(
            "INSERT INTO transactions (transaction_date, type, category, amount, description, created_at) 
            VALUES (:transaction_date, :type, :category, :amount, :description, NOW())"
        );

        // Bind parameters to the prepared statement
        $stmt->bindParam(':transaction_date', $transaction_date, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        echo "Transaction added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the connection
        $conn = null;
    }
}
?>


