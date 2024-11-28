<?php

class database{

    function opencon(){
        return new PDO('mysql:host=localhost;dbname=gerlysdatab', 'root' , '');

    }

    function checkGoogleId($google_id) {
        $con = $this->opencon();
        $query = "SELECT * FROM users WHERE google_id = :google_id LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':google_id', $google_id);
        $stmt->execute();
   
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC); // Return user data
        } else {
            return false;
        }
    }

    function signupUser($first_name, $last_name, $email, $phone = null, $password = null, $google_id = null, $microsoft_id = null) {
        $con = $this->opencon();
   
        try {
            if ($microsoft_id) {
                $stmt = $con->prepare("INSERT INTO users (first_name, last_name, email, phone, microsoft_id) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$first_name, $last_name, $email, $phone, $microsoft_id]);
            } elseif ($google_id) {
                $stmt = $con->prepare("INSERT INTO users (first_name, last_name, email, phone, google_id) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$first_name, $last_name, $email, $phone, $google_id]);
            } else {
                $stmt = $con->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$first_name, $last_name, $email, $phone, password_hash($password, PASSWORD_DEFAULT)]);
            }
           
            return $con->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error in signupUser: " . $e->getMessage());
            return false;
        }
    }


}