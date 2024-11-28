

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
            align-items: center; /* Align icon and text */
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .sidebar i {
            margin-right: 8px; /* Add space between icon and text */
        }
        .content {
            margin-left: 270px; /* Space for the sidebar */
            padding: 20px;
            flex: 1;
        }
        .logout {
            margin-top: auto; /* Push logout link to the bottom */
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
    <a href="payments.php"><i class="fas fa-credit-card"></i> Manage Payment</a>
    <a href="#logout" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <h1>Welcome to the Admin Panel</h1>
        <p>Select an option from the sidebar to get started.</p>
    </div>

</body>
</html>
