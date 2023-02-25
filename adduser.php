<?php
include "Person.php";
include "Connect.php";

$uid_in = $_POST["uid_in"];
$name_in = $_POST["name_in"];
$user_email_in = $_POST["user_email_in"];
$password_in = $_POST["password_in"];
$security_type_in = $_POST["security_type_in"];

// echo $uid_in;
// echo "<br>";
// echo $name_in;
// echo "<br>";
// echo $user_email_in;
// echo "<br>";
// echo $password_in;
// echo "<br>";
// echo $security_type_in;
// echo "<br>";

$con = new connectDB();
$p1 = new Person($con->connect());

if($p1->setDataToInsertAccount($uid_in,$name_in, $user_email_in, $password_in, $security_type_in)==true){
    echo "Successful";
}else {
    echo "Fail";
}


?>