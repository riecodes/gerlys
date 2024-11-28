<?php
$LoggedIn = isset($_SESSION['user_id']);
?>

<div class="header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        
        <!-- Logo Section -->
        <div class="logo d-flex align-items-center">
            <div class="image-container">
                <img src="image/gerlylogo.png" alt="Logo" class="img-fluid">
            </div>
            <h1 class="ml-3">Gerly's Catering Company</h1>
        </div>

        <!-- Navigation Links -->
        <nav class="main-nav">
            <ul class="navbar-nav d-flex justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sample-menu.php">Sample Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservation.php">Reservation</a>
                </li>
            </ul>
        </nav>

        <!-- Authentication Menu -->
        <div class="auth-menu">
            <?php if ($LoggedIn): ?>
                <p>Welcome, <?php echo ucfirst($_SESSION['first_name']); ?></p>
                <a href="logout.php" class="logout-link"><i class='bx bxs-user-circle'></i> Logout</a>
            <?php else: ?>
                <a href="login.php" class="login-link"><i class='bx bxs-user-circle'></i> Login</a>
            <?php endif; ?>
        </div>
        
    </div>
</div>