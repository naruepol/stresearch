<?php
// Novice Test
include "Person.php";

$p1 = new Person("2166","Somchai","somchai@myresearch.com","test","2");
// show password encrypt by security type 2
echo "Pass : ".$p1->getEncryptPassword();
echo "<br>";

// send EncryptType (Object) to change encrypt_strategy
// $p1->setEncryptType(new EncryptType2());
// send security_type (value) to change encrypt_strategy
$p1->setEncryptType("1");

// show update password  and plain password
echo "Pass : ".$p1->getEncryptPassword();
echo "<br>";
echo "Plain Password :".$p1->getPassword();
echo "<br>";

// password hash 
// $pass1 = password_hash("test", PASSWORD_DEFAULT);
// $pass2 = md5("test");
// echo "Pass 1: ".$pass1;
// echo "<br>";
// echo "Pass 2: ".$pass2;

// password hash verify
echo "<br>";
if (password_verify("test", $p1->getEncryptPassword())){
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}

// md5 verify
echo "<br>";
if (md5("test") == $p1->getEncryptPassword()){
    echo "Valid";
} else {
    echo 'Invalid';
}

?>