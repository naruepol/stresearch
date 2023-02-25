<?php
include "Person.php";
include "Connect.php";

$user_email_in = $_POST["user_email_in"];
$user_password_in = $_POST["user_password_in"];

// echo $user_email_in;
// echo "<br>";
// echo $user_password_in;
// echo "<br>";

$con = new connectDB();
$p1 = new Person($con->connect());

if($p1->checkLogin($user_email_in,$user_password_in)==true){
    echo "Login Pass";
}else{
    echo "Login Fail";
}

?>