<?php

$conn = mysqli_connect("localhost", "root", "",   "gerlysdatabase");


if (mysqli_connect_errno()){

    echo "Failed to connect to MYSQL" . mysqli_connect_errno();

}

?>