<?php
$con = mysqli_connect("localhost","root","","seni_lukis");

//check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to mySQL: " . mysqli_connect_errno();
    exit();
}
?>