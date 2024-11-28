<?php
require_once('classes/database.php');



session_start();

$con = new database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $googleId = $_POST['google_id'];

   
    $existingUser = $con->checkGoogleId($googleId);

    if ($existingUser) {
      
        $_SESSION['first_name'] = $existingUser['first_name'];
        $_SESSION['account_type'] = $existingUser['account_type'];
        $_SESSION['user_id'] = $existingUser['user_id'];


        $redirect = ($existingUser['account_type'] == 1) ? 'admin' : 'index.php';
        echo json_encode(['success' => true, 'redirect' => $redirect]);
    } else {

        $newUserId = $con->signupUser($firstName, $lastName, $email, '', null, $googleId);

        if ($newUserId) {
            // Set session and redirect user
            $_SESSION['first_name'] = $firstName;
            $_SESSION['account_type'] = 2; 
            $_SESSION['user_id'] = $newUserId;

      
            sendWelcomeEmail($email, $firstName);

            echo json_encode(['success' => true, 'redirect' => 'index.php']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error creating user account.']);
        }
    }
}

?>
