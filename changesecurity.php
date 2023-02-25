<?php
include "Person.php";
include "Connect.php";

$uid_in = $_POST["uid_in"];
$new_password = $_POST["new_password"];
$security_type_in = $_POST["security_type_in"];

// echo $uid_in;
// echo "<br>";
// echo $new_password;
// echo "<br>";
// echo $security_type_in;
// echo "<br>";

$con = new connectDB();
$p1 = new Person($con->connect());

if($p1->switchEncryptTypeUpdatePassword($security_type_in,$uid_in,$new_password)==true){
    echo "Successfully updated";
}else {
    echo "Update Failed";
}

?>