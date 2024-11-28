<?php

$first_name = $last_name = $phone = $email = $password = $confirm_password = "";
$first_nameErr = $last_nameErr = $phoneErr = $emailErr = $passwordErr = $confirmPasswordErr = "";

if (isset($_POST["btnRegister"])) {

    // Validate first name
    if (empty($_POST["first_name"])) {
        $first_nameErr = "Required!";
    } else {
        $first_name = $_POST["first_name"];
    }

    // Validate last name
    if (empty($_POST["last_name"])) {
        $last_nameErr = "Required!";
    } else {
        $last_name = $_POST["last_name"];
    }

    // Validate phone number
    if (empty($_POST["phone"])) {
        $phoneErr = "Required!";
    } else {
        $phone = $_POST["phone"];
        if (!preg_match("/^[0-9]{11}$/", $phone)) {
            $phoneErr = "Phone number must be 11 digits.";
        }
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Required!";
    } else {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required!";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters.";
        }
    }

    // Validate confirm password
    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Please confirm your password!";
    } else {
        $confirm_password = $_POST["confirm_password"];
        if ($password !== $confirm_password) {
            $confirmPasswordErr = "Passwords do not match!";
        }
    }

    // Check for errors and proceed with the database insertion if no errors
    if (empty($first_nameErr) && empty($last_nameErr) && empty($phoneErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        if (!preg_match("/^[a-zA-Z]*$/", $first_name)) {
            $first_nameErr = "Letters only and no space.";
        } else {
            $count_first_name_string = strlen($first_name);
            if ($count_first_name_string < 2) {
                $first_nameErr = "First name is too short.";
            } else {
                $count_last_name_string = strlen($last_name);
                if ($count_last_name_string < 2) {
                    $last_nameErr = "Last name is too short.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Hash the password
                    $account_type = '2';  // Define account_type

                    include("connections.php");
                    mysqli_query($conn, "INSERT INTO users (first_name, last_name, email, phone, password, account_type) 
                        VALUES ('$first_name', '$last_name', '$email', '$phone', '$hashed_password', '$account_type')");

                    echo "<script>window.location.href='login.php';</script>";
                }
            }
        }
    }
}

?>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #74b9ff, #a29bfe);
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .signup-container {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        padding: 40px;
        width: 450px;
        max-width: 90%;
        transition: transform 0.3s ease;
    }

    .signup-container:hover {
        transform: translateY(-10px);
    }

    h2 {
        text-align: center;
        color: #2d3436;
        font-size: 24px;
        margin-bottom: 20px;
    }

    input[type="text"], input[type="email"], input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        margin: 8px 0;
        border: 1px solid #dfe6e9;
        border-radius: 8px;
        font-size: 15px;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
        border-color: #74b9ff;
        outline: none;
    }

    input[type="submit"] {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #0984e3, #74b9ff);
        border: none;
        color: white;
        font-size: 18px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s;
    }

    input[type="submit"]:hover {
        background: linear-gradient(135deg, #74b9ff, #0984e3);
        transform: scale(1.05);
    }

    .error {
        color: #d63031;
        font-size: 14px;
        margin-top: 5px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
        color: #2d3436;
    }

    .form-group .icon {
        position: absolute;
        margin-left: 10px;
        margin-top: 12px;
        color: #636e72;
    }

    .form-control {
        position: relative;
        display: flex;
        align-items: center;
    }

    input::placeholder {
        color: #b2bec3;
        font-style: italic;
    }
</style>

<script type="application/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>

<!-- HTML Form Section -->
<div class="signup-container">
    <h2>Sign Up</h2>
    <form METHOD="POST">
        <div class="form-group form-control">
            <label for="first_name">First Name</label>
            <span class="icon"><i class="fa fa-user"></i></span>
            <input type="text" name="first_name" placeholder="First name" value="<?php echo $first_name; ?>"> 
            <span class="error"><?php echo $first_nameErr; ?></span>
        </div>

        <div class="form-group form-control">
            <label for="last_name">Last Name</label>
            <span class="icon"><i class="fa fa-user"></i></span>
            <input type="text" name="last_name" placeholder="Last name" value="<?php echo $last_name; ?>"> 
            <span class="error"><?php echo $last_nameErr; ?></span>
        </div>

        <div class="form-group form-control">
            <label for="phone">Phone Number</label>
            <span class="icon"><i class="fa fa-phone"></i></span>
            <input type="text" name="phone" placeholder="Phone number (e.g., 09123456789)" value="<?php echo $phone; ?>" maxlength="11" onkeypress='return isNumberKey(event)'> 
            <span class="error"><?php echo $phoneErr; ?></span>
        </div>

        <div class="form-group form-control">
            <label for="email">Email</label>
            <span class="icon"><i class="fa fa-envelope"></i></span>
            <input type="text" name="email" value="<?php echo $email; ?>" placeholder="Email"> 
            <span class="error"><?php echo $emailErr; ?></span>
        </div>

        <div class="form-group form-control">
            <label for="password">Password</label>
            <span class="icon"><i class="fa fa-lock"></i></span>
            <input type="password" name="password" placeholder="Password"> 
            <span class="error"><?php echo $passwordErr; ?></span>
        </div>

        <div class="form-group form-control">
            <label for="confirm_password">Confirm Password</label>
            <span class="icon"><i class="fa fa-lock"></i></span>
            <input type="password" name="confirm_password" placeholder="Confirm Password"> 
            <span class="error"><?php echo $confirmPasswordErr; ?></span>
        </div>

        <input type="submit" name="btnRegister" value="Register">
    </form>
</div>
