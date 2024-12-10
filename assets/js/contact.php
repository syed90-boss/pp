<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mobile = filter_var(trim($_POST['mobile']), FILTER_SANITIZE_STRING);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit();
    }

    if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        echo "Invalid mobile number. Please enter a 10-digit number.";
        exit();
    }

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "RoyalStreet";
    $dbname = "Shahae";

    // Connect to database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO form_submissions (name, mobile_number, email_id) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sss", $name, $mobile, $email);

    // Execute query
    if ($stmt->execute()) {
        echo "Form submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
