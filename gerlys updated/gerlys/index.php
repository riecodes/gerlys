<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerly's Catering Company</title>



    <link rel="stylesheet" href="css/style.css?v<?php echo time()?>">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap-4.5.3-dist/css/bootstrap.css">

    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap.css">

    <!-- Boxicon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>

<?php include('header.php') ?>

    <section class="homepage-top">
        <div class="home-title">
            <div class="title-page">
                <h1>Redefining Food & Event Production</h1>
            </div>
        </div>
    </section>
    
    <div class="home-image">
        <div class="home-container">
            <img src="image/catering_home.jpg" alt="">
        </div>
    </div>
    
    <section class="homepage-bottom">
        <div class="home-bottom">
            <h2>Services</h2>
            <div class="home-bottom-yey">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="home-bottom-title">
                                <h3>Weddings</h3>
                                <p>We will work with you to create a menu that fits your taste, budget, and style.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="home-bottom-title">
                                <h3>Corporate Events</h3>
                                <p>Our team of professionals includes chefs, servers, and bartenders committed to making your event spectacular.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="home-bottom-title">
                                <h3>Social Events</h3>
                                <p>Locally sourced produce and the freshest ingredients mean food that is exceptional in taste.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="service-section">

        <div class="service-top-container">

            <div class="service-title">

                <h2>Services</h2>

            </div>

        </div>

    </section>

    <section class="wedding">

        <div class="service-wedding-container">

            <div class="wedding-section">

                <div class="about-wedding">

                    <h3>Weddings</h3>

                    <p>Gerly's Catering Company makes your special day unforgettable with exquisite wedding catering. From elegant appetizers to gourmet meals, our customizable menu suits any style of celebration. Trust our team to deliver delicious dishes and seamless service, allowing you to savor every moment.</p>
                    
                    <a href="reservation.php?service=Weddings&price=100000">Book Now</a>

                </div>

                <img src="image/wedding.png" alt="">

            </div>

        </div>

    </section>

    <section class="corporate">

        <div class="service-corporate-events-container">

            <div class="corporate-events-section">

                <img src="image/corporate.jpg" alt="" style="width:30rem;">

                <div class="about-corporate-events">

                    <h3>Corporate Events</h3>

                    <p>Gerly's Catering Company brings professionalism and flavor to your corporate events. From business lunches to gala dinners, our diverse menu is tailored to impress clients, colleagues, and guests. Rely on us for seamless service and exceptional dishes that elevate your event.</p>

                    <a href="reservation.php?service=Corporate Events&price=75000">Book Now</a>

                </div>

            </div>

        </div>

    </section>

    <section class="social">

        <div class="service-social-events-container">

            <div class="social-events-section">

                <div class="about-social-events">

                    <h3>Social Events</h3>

                    <p>Whether it's a birthday, reunion, or any special gathering, Gerly's Catering Company adds flavor and flair to your social events. Our customizable menu and attentive service ensure a delightful experience, letting you and your guests enjoy every moment.
                    </p>

                    <a href="reservation.php?service=Social Events&price=50000">Book Now</a>

                </div>

                <img src="image/socialevents.jpg" alt="" style="width:30rem;">

            </div>

        </div>

    </section>
    
    <footer>

        <div class="footer-container">

            <div class="follow-us-icon">

                <h5>Follow Us:</h5>

                <ul>
                <li> <h5>Phone: 0906 616 2081 </h5></li>
                    <li><a href="https://www.facebook.com/GirliesLutongPagkain">
                        <i class='bx bxl-facebook-circle' ></i>
                    </a>
                </li>
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