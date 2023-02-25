<?php
include "EncryptAlgorithm.php";
include "EncryptType1.php";
include "EncryptType2.php";

class Person
{
    private $db;  // pdo database connection 
    private $uid;
    private $name;
    private $user_email;
    private $passwd;
    private $encypt_passwd;   // from passwd
    private $security_type = "1";
    private $encrypt_strategy = NULL;  // (object type) consider from security_type

    // new object when add user (by admin) (validate data before register)
    function __construct($con_in)
    {
        $this->db= $con_in;

    }

    public function setDataToInsertAccount($uid_in,$name_in, $user_email_in, $password_in, $security_type_in){
        $this->uid = $uid_in;
        $this->name = $name_in;
        $this->user_email = $user_email_in;
        $this->passwd = $password_in;
        $this->security_type = $security_type_in;
        $this->encrypt_strategy = $this->createSecurityType($security_type_in);

        // not delegate
        //$this->$encrypt_passwd = $this->$encrypt_strategy->encrypt($passwd);
        //delegate
        $this->encrypt_passwd = $this->performEncrypt();
        // insert into db (table person)
        
        //$this->insertUser();
    }
    
     // call by constructor
     // apply factory method to create object encryption type 
     // return EncryptAlgorithm
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

    // call by constructor
    // call by switchEncryptTypeUpdatePassword
    // delegate method 
    private function performEncrypt()
    {
        return $this->encrypt_strategy->encrypt($this->passwd);
    }

    // call by tester check to change algorithm (another class)
    // dynamic binding for test only
    public function setEncryptType($etype){
        if($etype==1){
            $this->encrypt_strategy = new EncryptType1();
        } else if($etype==2){
            $this->encrypt_strategy = new EncryptType2();
        }
        
        $this->encrypt_passwd = $this->performEncrypt();
    }

    // for test only
    public function getUid()
    {
        return $this->uid;
    }
   
    // for test only
    public function getName()
    {
        return $this->name;
    }

    // for test only
    public function getUserEmail()
    {
        return $this->user_email;
    }

    // for test only
    public function getPassword()
    {
        return $this->passwd;
    }

    // for test only
    public function getEncryptPassword()
    {
        return $this->encrypt_passwd;
    }

    // for test only
    public function getSecurityType()
    {
        return $this->security_type;
    }

    // call by constructor (when add user by admin)
    private function insertUser(){
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
            $stmt= $his->db->prepare($sql);
            $stmt->execute($data);
            return true;
        }
        catch (PDOException $e)
        {
            echo 'Query error.';
            die();
            return false;
        }
    }

    // call by Update Password Page (change security type and password)
    public function switchEncryptTypeUpdatePassword($etype,$uid,$new_password){
        if($etype==1){
            $this->encrypt_strategy = new EncryptType1();
        } else if($etype==2){
            $this->encrypt_strategy = new EncryptType2();
        }
        
        $this->passwd = $new_password;
        $this->encrypt_passwd = $this->performEncrypt();
        // param uid, new_password, security_type
        // gen new_encypt_passwd from new_password
        // change type and update new password to db (table person) by uid
        // update security_type, new_encypt_passwd by uid
        // return updatestatus (boolean)
    }

    // call by LogIn Page
    // return boolean
    public function checkLogin($user_email_in,$user_password_in){
        $this->user_email = user_email_in;
        $this->passwd = user_password_in;
        
        if($this->getPersonDataForVerify()==true){
            return $this->verifyEncrypt();
        }else{
            return false;
        }

    }

    // call by checkLogin
    // set $this->encypt_passwd before call
    // verify
    // return boolean
    private function verifyEncrypt(){
        if($this->security_type=="1"){
            if (password_verify($p1->getPassword(), $this->getEncryptPassword())){
               return true;
            } else {
               return false;
            }	
        }else if($this->security_type=="2"){
            if (md5($p1->getPassword()== $this->getEncryptPassword())){
                return true;
             } else {
                return false;
             }	        
        }
    }

    // get security_type_db and encypt_passwd_db from db
    // set security_type และ encypt_passwd for verify
    // change to public for test (default private)
    public function getPersonDataForVerify(){

        
        $sql = "SELECT * FROM person WHERE user_email=:uemail";
        try
        {
            $stmt= $this->db->prepare($sql);
            $stmt->execute(['uemail' => $this->getUserEmail()]);
            $person = $stmt->fetch();
            // $person (array result)
            echo $person['encypt_passwd'];
            echo "<br>";
            echo $person['security_type'];
            echo "<br>";
            // data for verify
            $this->security_type = $person['security_type'];
            $this->encypt_passwd = ['encypt_passwd'];
            return true;
        }
        catch (PDOException $e)
        {
            echo 'Query error.';
            die();
            return false;
        }        
    }    
}
?>