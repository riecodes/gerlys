<?php
session_start();
include 'connections.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'];
    $reservation_date = $_POST['reservation_date'] . ' ' . $_POST['reservation_time'];
    $address = $_POST['address'];
    $status = 'pending';

    // Get the first menu_id from the menu table
    $menu_id_result = $conn->query("SELECT menu_id FROM menu LIMIT 1");
    $menu_id = ($menu_id_result && $menu_id_result->num_rows > 0) ? $menu_id_result->fetch_assoc()['menu_id'] : null;

    if ($menu_id !== null) {
        // Insert reservation into the database
        $sql = "INSERT INTO reservations (user_id, service_id, menu_id, reservation_date, address, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiisss", $user_id, $service_id, $menu_id, $reservation_date, $address, $status);
        
        if ($stmt->execute()) {
            header("Location: reservation.php");
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        header("Location: reservation.php");
    }

    $conn->close();
}
?>
