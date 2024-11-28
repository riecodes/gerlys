<?php

session_start(); // Start the session
include 'connections.php'; // Ensure this includes your database connection

$service = isset($_GET['service']) ? $_GET['service'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';

// Check if the user is logged in
$LoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerly's Catering Company</title>
    
    <!-- Load jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AeOv0n8PofgzX6UdgyI5m-wFpp86rgqJ2sfflqlLaWa3ulj_6Uyai6TgsCkDeVy5VfFOPEpqaheR6PeF&currency=USD"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="bootstrap-4.5.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .reservation-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
        .button-container button, #paypal-button-container {
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>
<body>

<?php include('header.php'); ?>

<section class="reservation-section">
    <div class="reservation-title-container">
        <div class="reservation-title">
            <h3>Request a reservation</h3>
            <p>Select your details and we’ll try to get the best seats for you</p>
        </div>
    </div>

    <div class="reservation-inputs">
        <form id="reservation-form" action="process_reservation.php" method="POST">
            <div class="reservation-container">
                <!-- Guest Size -->
                <div class="guest-input">
                    <h6>Guest Size</h6>
                    <div class="dropdown">
                        <select name="guest_size" required>
                            <option value="">Select Guest Size</option>
                            <option value="1-10">1-10 guests</option>
                            <option value="11-50">11-50 guests</option>
                            <option value="51-100">51-100 guests</option>
                            <option value="100+">100+ guests</option>
                        </select>
                    </div>
                </div>

                <!-- Date -->
                <div class="date-input">
                    <h6>Date</h6>
                    <input type="date" name="reservation_date" required>
                </div>

                <!-- Time -->
                <div class="time-input">
                    <h6>Time</h6>
                    <input type="time" name="reservation_time" required>
                </div>

                <div class="reservation-container">

                    <!-- Service Selection (Dropdown) -->
                    <div class="service-input">
                        <h6>Select a Service</h6>
                        <?php
                        include 'connections.php';
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        // Fetch services with their prices
                        $sql = "SELECT service_id, service_name, service_description, service_price FROM service";
                        $result = $conn->query($sql);
                        ?>
                        
                        <div class="dropdown">
                            <select name="service_id" id="service_dropdown" required onchange="updateServiceDetails()">
                                <option value="">Choose a Service</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        // Store service name and price as data attributes for easy access in JavaScript
                                        echo "<option value='" . $row['service_id'] . "' data-service-name='" . $row['service_name'] . "' data-price='" . $row['service_price'] . "'>" . $row['service_name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No services available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <?php $conn->close(); ?>
                    </div>

                    <!-- Price Display (Readonly) -->
                    <div class="price-input">
                        <h6>Price</h6>
                        <input type="text" id="price" name="price" value="" readonly>
                    </div>

                    <!-- Address -->
                    <div class="guest-input">
                        <h6>Event Address</h6>
                        <input type="text" name="address" placeholder="Enter event address" required ">
                    </div>
                </div>

                <!-- Button Container -->
                <div class="button-container">
                    <button type="submit" class="btn btn-secondary" id="pay-button">Book Now</button>
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </form>
    </div>
</section>

<footer>
    <div class="footer-container">
        <div class="follow-us-icon">
            <h5>Follow Us:</h5>
            <ul>
                <li><h5>Phone: 0906 616 2081</h5></li>
                <li><a href="https://www.facebook.com/GirliesLutongPagkain"><i class='bx bxl-facebook-circle'></i></a></li>
            </ul>
        </div>
        <div class="copyright">
            <p>Copyright &copy; 2024. All rights Gerly's Catering Company reserved.</p>
        </div>
    </div>
</footer>

<script>
    function updateServiceDetails() {
        const serviceDropdown = document.getElementById('service_dropdown');
        const selectedOption = serviceDropdown.options[serviceDropdown.selectedIndex];
        const servicePrice = selectedOption.getAttribute('data-price');

        // Update the input fields
        document.getElementById('price').value = servicePrice ? servicePrice : '';
        document.getElementById('pay-button').disabled = !servicePrice;
    }

    paypal.Buttons({
        createOrder: function(data, actions) {
            const price = document.getElementById('price').value; // Get the dynamic price
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: price || '0.00' // Use dynamic value or fallback to 0
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            console.log("Payment approved:", data);
            return actions.order.capture().then(function(details) {
                console.log("Payment captured:", details);
                
                // Collect data from the reservation form
                const guestSize = document.querySelector('select[name="guest_size"]').value;
                const reservationDate = document.querySelector('input[name="reservation_date"]').value;
                const reservationTime = document.querySelector('input[name="reservation_time"]').value;
                const serviceId = document.querySelector('select[name="service_id"]').value;

                // Submit the reservation form first
                $.ajax({
                    url: 'process_reservation.php',
                    method: 'POST',
                    data: {
                        guest_size: guestSize,
                        reservation_date: reservationDate,
                        reservation_time: reservationTime,
                        service_id: serviceId,
                        address: document.querySelector('input[name="address"]').value // Include address if needed
                    },
                    success: function(reservationResponse) {
                        console.log('Reservation successful:', reservationResponse);

                        // Now send payment details after the reservation is successful
                        $.ajax({
                            url: 'process_payment.php',
                            method: 'POST',
                            data: {
                                transaction_id: details.id,
                                payer_name: details.payer.name.given_name + ' ' + details.payer.name.surname,
                                payer_email: "<?php echo $_SESSION['email']; ?>", // Session email from PHP
                                amount: details.purchase_units[0].amount.value,
                                total_amount: details.purchase_units[0].amount.value,
                                payment_status: details.status,
                                customer_id: "<?php echo $_SESSION['user_id']; ?>",
                                payment_date: new Date().toISOString()
                            },
                            success: function(paymentResponse) {
                                alert('Payment completed and recorded.');
                                console.log('PAYMENT COMPLETE', paymentResponse);
                                // Optionally redirect or update the UI
                            },
                            error: function(xhr, status, error) {
                                console.error('Error in payment processing:', error);
                                alert('Payment could not be processed. Please try again.');
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error in reservation processing:', error);
                        alert('Reservation could not be processed. Please try again.');
                    }
                });
            });
        }
    }).render('#paypal-button-container');
</script>


</body>
</html>
