<?php
// Database connection
$host = "localhost";
$dbname = "user_db";
$db_user = "root";
$db_pass = "";

$conn = new mysqli($host, $db_user, $db_pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$alert = ""; // For alert messages

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first = trim($_POST['first_name']);
    $last = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@gmail.com')) {
        $alert = "❌ Please enter a valid Gmail address.";
    } else {
        // Insert user into database table `user_db` (first_name, last_name, email, password)
        $stmt = $conn->prepare("INSERT INTO user_db (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first, $last, $email, $password);

        if ($stmt->execute()) {
            $alert = "✅ Registered successfully!";
        } else {
            $alert = "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script>
        // Show alert from PHP if available
        <?php if (!empty($alert)): ?>
            alert("<?= addslashes($alert); ?>");
        <?php endif; ?>
    </script>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="">
        <label>First Name:</label><br>
        <input type="text" name="first_name" required style="width: 100%;"><br><br>

        <label>Last Name:</label><br>
        <input type="text" name="last_name" required style="width: 100%;"><br><br>

        <label>Gmail Address:</label><br>
        <input type="email" name="email" required style="width: 100%;"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required style="width: 100%;"><br><br>

        <input type="submit" value="Register">
    </form>
</body>

</html>