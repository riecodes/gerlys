<?php
$connection = mysqli_connect("localhost", "root", "", "gerlysdatabase");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Handle deleting a user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $query = "DELETE FROM users WHERE user_id = '$user_id'";
    if (mysqli_query($connection, $query)) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . mysqli_error($connection);
    }
}

// Fetch users
$query = "SELECT user_id, first_name, last_name, email, phone FROM users";
$result = mysqli_query($connection, $query);

if (!$result) {
    echo "Error fetching users: " . mysqli_error($connection);
    exit();
}

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            height: 100vh;
            position: fixed;
        }
        .sidebar h2 {
            text-align: center;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center; 
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .sidebar i {
            margin-right: 8px; 
        }
        .content {
            margin-left: 270px; 
            padding: 20px;
            flex: 1;
        }
        .table-container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
    </style>
</head>
<body>
    
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="user.php"><i class="fas fa-user"></i> Manage User</a>
        <a href="menu.php"><i class="fas fa-utensils"></i> Manage Menu</a>
        <a href="reservation.php"><i class="fas fa-calendar-check"></i> Manage Reservation</a>
        <a href="payment.php"><i class="fas fa-credit-card"></i> Manage Payment</a>
        <a href="#logout" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <div class="table-container">
            <h2>User Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo htmlspecialchars($user['user_id']); ?>">Edit</a>
                            <form action="user.php" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
