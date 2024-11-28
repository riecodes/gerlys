<?php
$connection = mysqli_connect("localhost", "root", "", "gerlysdatab");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Insert or update payment if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = mysqli_real_escape_string($connection, $_POST['userId']);
    $amount = mysqli_real_escape_string($connection, $_POST['amount']);
    $paymentDate = mysqli_real_escape_string($connection, $_POST['paymentDate']);
    $paymentStatus = mysqli_real_escape_string($connection, $_POST['paymentStatus']);
    $paymentId = isset($_POST['paymentId']) ? mysqli_real_escape_string($connection, $_POST['paymentId']) : null;

    if ($paymentId) {
        // Update existing payment
        $sql = "UPDATE payment SET user_id='$userId', amount='$amount', payment_date='$paymentDate', payment_status='$paymentStatus' WHERE payment_id='$paymentId'";
    } else {
        // Insert new payment
        $sql = "INSERT INTO payment (user_id, amount, payment_date, payment_status) VALUES ('$userId', '$amount', '$paymentDate', '$paymentStatus')";
    }

    if (!mysqli_query($connection, $sql)) {
        echo "Error: " . mysqli_error($connection);
    }
}

// Delete payment
if (isset($_GET['delete_id'])) {
    $paymentId = mysqli_real_escape_string($connection, $_GET['delete_id']);
    $sql = "DELETE FROM payment WHERE payment_id='$paymentId'";
    if (!mysqli_query($connection, $sql)) {
        echo "Error: " . mysqli_error($connection);
    }
}

// Fetch existing payments
$payments = mysqli_query($connection, "SELECT * FROM payment");

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; display: flex; }
        .sidebar { width: 250px; background-color: #2c3e50; color: white; padding: 15px; height: 100vh; position: fixed; }
        .sidebar h2 { text-align: center; }
        .sidebar a { color: white; text-decoration: none; display: flex; align-items: center; padding: 10px; margin: 15px 0; border-radius: 5px; transition: background-color 0.3s; }
        .sidebar a:hover { background-color: #34495e; }
        .content { margin-left: 270px; padding: 20px; flex: 1; }
        .table-container { margin-top: 20px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: center; border: 1px solid #ddd; }
        th { background-color: #2c3e50; color: white; }
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
    <div class="table-container">
        <h1>Payment Management</h1>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User ID</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($payments as $index => $payment): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($payment['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($payment['amount']); ?></td>
                    <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                    <td><?php echo htmlspecialchars($payment['payment_status']); ?></td>
                    <td>
                        <button class='btn btn-warning btn-sm' onclick='editPayment(<?php echo $payment['payment_id']; ?>, "<?php echo htmlspecialchars($payment['user_id']); ?>", "<?php echo htmlspecialchars($payment['amount']); ?>", "<?php echo htmlspecialchars($payment['payment_date']); ?>", "<?php echo htmlspecialchars($payment['payment_status']); ?>")'>Edit</button>
                        <a href='?delete_id=<?php echo $payment['payment_id']; ?>' class='btn btn-danger btn-sm' onclick='return confirm("Are you sure you want to delete this payment?");'>Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
