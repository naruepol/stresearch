<?php
include "EncryptAlgorithm.php";
include "EncryptType1.php";
include "EncryptType2.php";

class Person
{
    private $uid;
    private $name;
    private $user_email;
    private $passwd;
    private $encypt_passwd;
    private $security_type = "1";
    private $encrypt_strategy = NULL;
    function __construct($uid_in,$name_in, $user_email_in, $password_in, $security_type_in)
    {
        $this->uid = $uid_in;
        $this->name = $name_in;
        $this->user_email = $user_email_in;
        $this->passwd = $password_in;
        $this->security_type = $security_type_in;
        $this->encrypt_strategy = $this->createSecurityType($security_type_in);

        //$this->$encrypt_passwd = $this->$encrypt_strategy->encrypt($passwd);
        $this->encrypt_passwd = $this->performEncrypt();
        // insert into db (table person)
        $this->insertUser();
    }
    
    private function createSecurityType($stid)
    {
        switch ($stid) {
            case "1";
                return new EncryptType1();
                break;
            case "2";
                return new EncryptType2();
                break;
        }
    }

    private function performEncrypt()
    {
        return $this->encrypt_strategy->encrypt($this->passwd);
    }

    public function setEncryptType($etype){
        if($etype==1){
            $this->encrypt_strategy = new EncryptType1();
        } else if($etype==2){
            $this->encrypt_strategy = new EncryptType2();
        }
        
        $this->encrypt_passwd = $this->performEncrypt();
        // change type and update new password to db (table person)
    }

    public function getUid()
    {
        return $this->uid;
    }
   
    public function getName()
    {
        return $this->name;
    }

    public function getUserEmail()
    {
        return $this->user_email;
    }

    public function getPassword()
    {
        return $this->passwd;
    }

    public function getEncryptPassword()
    {
        return $this->encrypt_passwd;
    }
    public function getSecurityType()
    {
        return $this->security_type;
    }

    private function insertUser(){
        $host = 'localhost';
        $user = 'root';
        $cpasswd = '';
        $schema = 'organization';
        $pdo = NULL;
        $dsn = 'mysql:host=' . $host . ';dbname=' . $schema;
        try
        {  
        $pdo = new PDO($dsn, $user,  $cpasswd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
        echo 'Database connection failed.';
        die();
        } 
        $data = [
            'uid' => $this->uid,
            'name' => $this->name,
            'email' => $this->user_email,
            'epasswd' => $this->encrypt_passwd,
            'st' => $this->security_type,
        ];
        $sql = "INSERT INTO person (user_id , user_name, user_email, encypt_passwd, security_type) VALUES (:uid, :name, :email, :epasswd, :st)";
        try
        {
            $stmt= $pdo->prepare($sql);
            $stmt->execute($data);
        }
        catch (PDOException $e)
        {
            echo 'Query error.';
            die();
        }
    }
}
?>