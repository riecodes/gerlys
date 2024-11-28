<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerly's Catering Company</title>

    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap-4.5.3-dist/css/bootstrap.css">

    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap.css">

    <!-- Boxicon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>

    <div class="header">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-4">

                    <div class="login-menu">

                        <a href="login.php"><i class='bx bxs-user-circle'></i>Login</a>
            
                    </div>

                </div>

                <div class="col-md-4">

                    <div class="logo">

                        <div class="image-container">
            
                            <img src="image/GerlysLogo.png" alt="">
            
                        </div>
            
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="navbars">

        <div class="menu">

            <ul>
                <li><a href="index.php" style="text-decoration: none;">Home</a></li>
                <li><a href="sample-menu.php" style="text-decoration: none;">Sample Menu</a></li>
                <li><a href="reservation.php" style="text-decoration: none;">Reservation</a></li>
            </ul>

        </div>

    </div>

    <section class="reservation-section">
        <div class="reservation-title-container">
            <div class="reservation-title">
                <h3>Request a reservation</h3>
                <p>Select your details and we’ll try to get the best seats for you</p>
            </div>
        </div>

        <div class="reservation-inputs">
            <form action="process_reservation.php" method="POST">
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

                    <!-- Service Selection -->
                    <div class="service-input">
                        <h6>Services</h6>
                        <?php
                        include 'connections.php';
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql = "SELECT service_id, service_name FROM service";
                        $result = $conn->query($sql);
                        ?>
                        <div class="dropdown">
                            <select name="service_id" required>
                                <option value="">Select Service</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['service_id'] . "'>" . $row['service_name'] . "</option>";
                                    }
                                } else {
                                    echo "<option>No services available</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <?php $conn->close(); ?>
                    </div>

                    <!-- Address -->
                    <div class="guest-input">
                        <h6>Event Address</h6>
                        <input type="text" name="address" placeholder="Enter event address" required>
                    </div>

                </div>

                <!-- Book Now Button -->
                <div class="button-container">
                    <center>
                        <button type="submit" class="btn btn-secondary">Book Now</button>
                    </center>
                    
                </div>
            </form>
        </div>
    </section>

    <footer>

        <div class="footer-container">

            <div class="follow-us-icon">

                <h5>Follow Us:</h5>

                <ul>
                    <li> <h5>Phone: 0906 616 2081 </h5></li>
                    <li><a href="https://www.facebook.com/GirliesLutongPagkain">
                    <li><a href=""><i class='bx bxl-facebook-circle' ></i></a></li>
                </ul>

            </div>

            <div class="copyright">

                <p class="copyright">Copyright &copy; 2024 . All rights Gerly's Catering Company reserved.</p>

            </div>

        </div>
        
    </footer>

</body>

<script src="/js/script.js"></script>
<script src="/bootstrap-4.5.3-dist/js/bootstrap.js"></script>
<script src="/bootstrap-5.3.3-dist/js/bootstrap.js"></script>

</html>