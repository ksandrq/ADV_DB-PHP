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

$users = [];
$error = "";

// Fetch users from table `user_db` (first_name, last_name, email)
$sql = "SELECT id, first_name, last_name, email, created_at FROM user_db ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $result->free();
} else {
    $error = "Error fetching users: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registered Users</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 5px; }
        th { background:rgb(196, 184, 184); text-align: left; }
        .container { max-width: 1000px; margin: 24px auto; font-family: Arial, sans-serif; }
        .empty { color: #666; }
        .back { margin-bottom: 12px; display: inline-block; }
    </style>
    <script>
        <?php if (!empty($error)): ?>
            alert("<?= addslashes($error); ?>");
        <?php endif; ?>
    </script>
</head>
<body>
    <div class="container">
        
        <h2>Registered Users</h2>

        <?php if (empty($users)): ?>
            <p class="empty">No users found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['id']); ?></td>
                            <td><?= htmlspecialchars($u['first_name']); ?></td>
                            <td><?= htmlspecialchars($u['last_name']); ?></td>
                            <td><?= htmlspecialchars($u['email']); ?></td>
                            <td><?= htmlspecialchars($u['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>

