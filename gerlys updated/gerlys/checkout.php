<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// PayPal Configuration
$paypalClientId = "AeOv0n8PofgzX6UdgyI5m-wFpp86rgqJ2sfflqlLaWa3ulj_6Uyai6TgsCkDeVy5VfFOPEpqaheR6PeF"; // Replace with your actual PayPal Client ID

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Gerly's Catering</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AeOv0n8PofgzX6UdgyI5m-wFpp86rgqJ2sfflqlLaWa3ulj_6Uyai6TgsCkDeVy5VfFOPEpqaheR6PeF<?php echo $paypalClientId; ?>&currency=USD"></script>
    <style>
        /* Style the checkout section */
        .checkout-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }
        .checkout-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .paypal-button-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="checkout-section">
    <div class="checkout-container">
        <h2>Complete Your Reservation Payment</h2>
        <p>Thank you for choosing Gerly's Catering. Please proceed with the payment to confirm your reservation.</p>
        
        <!-- PayPal Button -->
        <div id="paypal-button-container" class="paypal-button-container"></div>
    </div>
</div>

<script>
    // PayPal Button Render
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '100.00' // Replace this with your dynamic total amount
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Transaction completed by ' + details.payer.name.given_name);

                // Redirect to a success page or handle the server-side validation
                window.location.href = 'success.php';
            });
        }
    }).render('#paypal-button-container');
</script>

</body>
</html>
