<?php
session_start();
include('connections.php');







$secretKey = '6LdrbWcqAAAAAL4f6Jo6Xv99QOj5fV3dBBASZTOo';

// Set default timezone and initialize variables
date_default_timezone_set("Asia/Manila");
$date_now = date("m/d/Y");
$time_now = date("h:i a");

$notify = $attempt = $log_time = "";
$end_time = date("h:i A", strtotime("+15 minutes", strtotime($time_now)));
$email = $password = "";
$emailErr = $passwordErr = "";

// Handle form submission
if (isset($_POST['Login'])) {
    // Validate email
    if (empty($_POST['email'])) {
        $emailErr = "Email is required";
    } else {
        $email = $_POST['email'];
    }

    // Validate password
    if (empty($_POST['password'])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST['password'];
    }

    // Verify reCAPTCHA response
    if (!empty($_POST['g-recaptcha-response'])) {
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
        $responseData = json_decode($verifyResponse);

        if ($responseData->success) {
            // If no validation errors, proceed to check credentials
            if ($email && $password) {
                // Check if the email exists
                $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
                $check_row = mysqli_num_rows($check_email);

                if ($check_row > 0) {
                    $fetch = mysqli_fetch_assoc($check_email);
                    $db_first_name = $fetch['first_name'];
                    $db_password = $fetch['password'];
                    $db_attempt = $fetch['attempt'];
                    $db_log_time = strtotime($fetch['log_time']);
                    $my_log_time = $fetch['log_time'];
                    $new_time = strtotime($time_now);
                    $account_type = $fetch['account_type'];

                    // Admin check
                    if ($account_type == 1) {
                        if ($db_password == $password) {
                            $_SESSION['email'] = $fetch['email']; 
                            echo "<script>window.location.href='admin/index.php';</script>";
                        } else {
                            $passwordErr = "Hi Admin! Your password is incorrect!";
                        }
                    } else { 
                        // Regular user check
                        if ($db_log_time <= $new_time) {
                            if ($db_password == $password) {
                                $_SESSION['email'] = $fetch['email'];
                                $_SESSION['user_id'] = $fetch['user_id'];
                                mysqli_query($conn, "UPDATE users SET attempt='', log_time='' WHERE email='$email'");
                                echo "<script>window.location.href='index.php';</script>";
                            } else {
                                $attempt = (int)$db_attempt + 1;

                                // Lock account after 3 attempts
                                if ($attempt >= 3) {
                                    $attempt = 3;
                                    mysqli_query($conn, "UPDATE users SET attempt='$attempt', log_time='$end_time' WHERE email='$email'");
                                    $notify = "You have reached the maximum attempts. Please try again after 15 minutes: <b>$end_time</b>";
                                } else {
                                    mysqli_query($conn, "UPDATE users SET attempt='$attempt' WHERE email='$email'");
                                    $passwordErr = "Password is incorrect.";
                                    $notify = "Login Attempt: <b>$attempt</b>";
                                }
                            }
                        } else {
                            $notify = "Sorry $db_first_name, you must wait until: <b>$my_log_time</b> to log in again.";
                        }
                    }
                } else {
                    $emailErr = "Email is not registered.";
                }
            }
        } else {
            $notify = "reCAPTCHA verification failed. Please try again.";
        }
    } else {
        $notify = "Please complete the reCAPTCHA.";
    }
}
?>

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

    <!-- Google reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>

    <script src="https://accounts.google.com/gsi/client" async defer></script>

</head>
<body>

    <div class="back-btn">
        <a href="index.php"><i class='bx bx-x'></i></a>
    </div>

    <div class="login-container">

        <div class="login-details">
            <div class="login-title">
                <h1>Log In</h1>
                <h5>New to this site? <a href="signup.php">Sign Up</a> </h5>

                <div id="g_id_onload"
               data-client_id="1039556626950-4o179hts3obf6vucrrcb20229a5op71g.apps.googleusercontent.com"
               data-callback="handleCredentialResponse"
               data-auto_prompt="false"></div>
                <div class="g_id_signin" data-type="standard"></div>
    

                <div class="outlook-login">
                    <button class="login-email">
                        <h5>Log in with Outlook</h5>
                    </button>
                </div>

                <h6>or</h6>
                <div class="login-with-email">
                    <button class="login-email">
                        <h6>Login with Email</h6>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <div class="login-form">
        <div class="login-containers">
            <form method="POST">
                <div class="logins-form">
                    <div class="login-titles">
                        <h1>Log In</h1>
                        <h5>New to this site? <a href="signup.php">Sign Up</a> </h5>
                    </div>

                    <div class="login-inputs">
                        <h4>Emails</h4>
                        <input type="email" placeholder="Enter Email" name="email" id="">
                        <h4>Password</h4>
                        <input type="password" placeholder="Enter Password" name="password" id="">
                    </div>

                    <!-- reCAPTCHA widget -->
                    <div class="g-recaptcha" data-sitekey="6LdrbWcqAAAAACLHxDRBe3-2-BRlJMbszjyRXz-s" data-action="LOGIN"></div>

                    <div class="login-btn">
                        <input type="submit" name="Login" value="Login">
                    </div>

                    <div class="error">
                        <p><?php echo $emailErr; ?></p>
                        <p><?php echo $passwordErr; ?></p>
                        <p><?php echo $notify; ?></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</body>

<!-- Handle Google Sign-In response -->
<script>
    function handleCredentialResponse(response) {
      const responsePayload = JSON.parse(atob(response.credential.split('.')[1]));
 
      const formData = new FormData();
      formData.append('first_name', responsePayload.given_name);
      formData.append('last_name', responsePayload.family_name);
      formData.append('email', responsePayload.email);
      formData.append('google_id', responsePayload.sub);
 
      fetch('google-signin-handler.php', {
          method: 'POST',
          body: formData
      }).then(response => response.json())
        .then(data => {
          if (data.success) {
              window.location.href = data.redirect;
          } else {
              alert(data.message);
          }
      });
    }
  </script>


<script>
// Existing JS
const loginDetails = document.querySelector(".login-details");
const loginEmailBtn = document.querySelector(".login-with-email");
const loginForm = document.querySelector(".login-form");

loginEmailBtn.addEventListener("click", () => {
  loginForm.style.display = "block";
  loginEmailBtn.style.display = "none";
  loginDetails.style.display = "none";
});
</script>

<script src="/bootstrap-4.5.3-dist/js/bootstrap.js"></script>
<script src="/bootstrap-5.3.3-dist/js/bootstrap.js"></script>

</html>
