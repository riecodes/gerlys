<?php
session_start();
include 'connections.php'; // Ensure database connection file is correct
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve payment details from AJAX
    $transaction_id = $_POST['transaction_id'];
    $payer_name = $_POST['payer_name'];
    $payer_email = $_POST['payer_email'];
    $amount = $_POST['amount'];
    $total_amount = $_POST['total_amount'];
    $status = $_POST['status'];

    // Retrieve the customer ID from the session (assuming it’s stored there)
    $customer_id = $_SESSION['user_id']; // Adjust if the session key is different

    // Prepare and execute the SQL statement to store the payment details
    $stmt = $conn->prepare("INSERT INTO payments (customer_id, transaction_id, payer_name, payer_email, amount, total_amount, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssdss", $customer_id, $transaction_id, $payer_name, $payer_email, $amount, $total_amount, $status);

    if ($stmt->execute()) {
        echo "Payment recorded successfully.";
        
        // Fetch reservation details to include in the email
        $reservation_query = $conn->prepare("SELECT r.reservation_date, r.address, m.menu_name, s.service_name FROM reservations r JOIN menu m ON r.menu_id = m.menu_id JOIN service s ON r.service_id = s.service_id WHERE r.user_id = ? ORDER BY r.created_at DESC LIMIT 1");
        $reservation_query->bind_param("i", $customer_id);
        $reservation_query->execute();
        $reservation_result = $reservation_query->get_result();

        if ($reservation_result->num_rows > 0) {
            $reservation = $reservation_result->fetch_assoc();
            $reservation_date = date('F j, Y, g:i a', strtotime($reservation['reservation_date']));

            // Prepare the email
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server address
            $mail->SMTPAuth = true;
            $mail->Username = 'bronzetoconqueror03@gmail.com'; // Your email address
            $mail->Password = 'qdvk ricl cdex pjww'; // Your app password (if required)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Set email format
            $mail->setFrom('bronzetoconqueror03@gmail.com', 'Gerly\'s Catering Company');
            $mail->addAddress($payer_email);
            $mail->Subject = 'Reservation Payment Confirmation';
            $mail->isHTML(true);

            // Construct email body
            $mail_body = "
                <h3>Hi, {$payer_name}</h3>
                <p>Thank you for your reservation. Here are your payment and reservation details:</p><br>
                <h4><strong>Payment Information:</strong></h4>
                <p>Transaction ID: {$transaction_id}<br>
                Amount: {$amount}<br>
                Payment Date: " . date('F j, Y') . "</p><br>
                <h4><strong>Reservation Details:</strong></h4>
                <p>Service: {$reservation['service_name']}<br>
                Date: {$reservation_date}<br>
                Address: {$reservation['address']}</p>
            ";

            $mail->Body = $mail_body;

            // Send the email
            if ($mail->send()) {
                echo "Confirmation email sent successfully.";
            } else {
                echo "Error sending confirmation email: " . $mail->ErrorInfo;
            }
        } else {
            echo "No reservation details found.";
        }

        $reservation_query->close();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
