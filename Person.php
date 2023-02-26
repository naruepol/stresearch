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
    private $encrypt_passwd;   // from passwd
    private $security_type = "1";
    private $encrypt_strategy = NULL;  // (object type) consider from security_type

    // new object when add user (by admin) (validate data before register)
    // call before use method
    function __construct($con_in)
    {
        $this->db= $con_in;
    }

    // public for test only  // use private
    // call by insertUser
    private function getUid()
    {
        return $this->uid;
    }
   
    // public for test only  // use private
    // call by insertUser
    private function getName()
    {
        return $this->name;
    }

    // public for test only  // use private
    // call by insertUser
    // call by getPersonDataForVerify
    private function getUserEmail()
    {
        return $this->user_email;
    }

    // public for test only  // use private
    // call by 
    // call by verifyEncrypt
    private function getPassword()
    {
        return $this->passwd;
    }

    // public for test only // use private
    // call by verifyEncrypt
    private function getEncryptPassword()
    {
        return $this->encrypt_passwd;
    }

    // public for test only // use private
    // call by insertUser
    // call by verifyEncrypt
    private function getSecurityType()
    {
        return $this->security_type;
    }

    // used by add account page
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

        // disable for test
        // insert into db (table person)
        if($this->insertUser()==true){
            return true;
        }else{
            return false;
        }
    }
    
    // call by setDataToInsertAccount
    // apply factory method to create object encryption type 
    // return EncryptAlgorithm
    private function createSecurityType($stid)
    {
        $this->security_type = $stid;
        switch ($this->security_type) {
            case "1";
                return new EncryptType1();
                break;
            case "2";
                return new EncryptType2();
                break;
        }
    }

    // call by setDataToInsertAccount (when add user by admin)
    private function insertUser(){
        $data = [
            'uid' => $this->getUid(),
            'name' => $this->getName(),
            'email' => $this->getUserEmail(),
            'epasswd' => $this->getEncryptPassword(),
            'st' => $this->getSecurityType(),
        ];
        $sql = "INSERT INTO person (user_id , user_name, user_email, encrypt_passwd, security_type) VALUES (:uid, :name, :email, :epasswd, :st)";
        try
        {
            $stmt= $this->db->prepare($sql);
            $stmt->execute($data);
            return true;
        }
        catch (PDOException $e)
        {
            echo 'Insert error.';
            die();
            return false;
        }
    }

    // used by Update Password Page (change security type and password)
    // param user_id, new_password, security_type
    public function switchEncryptTypeUpdatePassword($etype_in,$uid_in,$new_password_in){
        $this->uid = $uid_in;
        $this->security_type = $etype_in;
        $this->passwd = $new_password_in;
        if($this->getSecurityType()==1){
            $this->encrypt_strategy = new EncryptType1();
        } else if($this->getSecurityType()==2){
            $this->encrypt_strategy = new EncryptType2();
        }

        // gen new_encrypt_passwd from new_password
        $this->encrypt_passwd = $this->performEncrypt();
        // check data befor implement
        // echo "<br>";
        // echo "UID : ".$this->getUid();
        // echo "<br>";
        // echo "Security_type : ".$this->getSecurityType();      
        // echo "<br>";
        // echo "NP1 : ".$this->getPassword();
        // echo "<br>";
        // echo "ENP1 : ".$this->getEncryptPassword();
        // echo "<br>";
        // change attribute securyity_type and encrypt_passwd
        // update new_security_type, new_encypt_passwd to db (table person) by user_id
        if($this->updateUserSecurity()==true){
            return true;
        }else {
            return false;
        }
        // return update status (boolean)
    }

    // call by switchEncryptTypeUpdatePassword (when change password by admin)
    private function updateUserSecurity(){
        $data = [
            'uid' => $this->getUid(),
            'epasswd' => $this->getEncryptPassword(),
            'st' => $this->getSecurityType(),
        ];
        $sql = "UPDATE person SET encrypt_passwd=:epasswd, security_type=:st WHERE user_id=:uid";
        try
        {
            $stmt= $this->db->prepare($sql);
            $stmt->execute($data);
            return true;
        }
        catch (PDOException $e)
        {
            echo 'Update error.';
            die();
            return false;
        }
    }

    // used by LogIn Page
    // return boolean
    public function checkLogin($user_email_in,$user_password_in){
        $this->user_email = $user_email_in;
        $this->passwd = $user_password_in;
        // echo $this->user_email;
        // echo "<br>";
        // echo $this->passwd;

        // get encrypt_passwd and security_type
        // set $this->security_type, $this->encrypt_passwd
        if($this->getPersonDataForVerify()==true){
            return $this->verifyEncrypt();
        }else{
            return false;
        }

    }

    // call by setDataToInsertAccount
    // call by switchEncryptTypeUpdatePassword
    // delegate method  
    private function performEncrypt()
    {
        return $this->encrypt_strategy->encrypt($this->passwd);
    }

    // call by checkLogin
    // set $this->encrypt_passwd before call (by getPersonDataForVerify)
    // verify
    // return boolean
    private function verifyEncrypt(){
        if($this->getSecurityType() =="1"){
            $this->encrypt_strategy = new EncryptType1();
            return $this->encrypt_strategy->verify($this->getPassword(),$this->getEncryptPassword());
        }else if($this->getSecurityType() =="2"){
            // echo "Password : ".$this->getPassword();
            $this->encrypt_strategy = new EncryptType2();
            // echo "<br>";
            // echo "Encrypt : ".$this->getEncryptPassword();
            // echo "<br>";
            return $this->encrypt_strategy->verify($this->getPassword(),$this->getEncryptPassword());      
        }
    }

    // get security_type_db and encrypt_passwd_db from db
    // set security_type และ encrypt_passwd for verify
    // call by checkLogin
    // change to public for test (default private)
    private function getPersonDataForVerify(){
        $sql = "SELECT * FROM person WHERE user_email=:uemail";
        try
        {
            $stmt= $this->db->prepare($sql);
            $stmt->execute(['uemail' => $this->getUserEmail()]);
            $person = $stmt->fetch();
            // person (array result)
            // for novice test
            // echo 'Enter Query.';
            // echo "<br>";
            // echo $person['encrypt_passwd'];
            // echo "<br>";
            // echo $person['security_type'];
            // echo "<br>";
            // data for verify
            if(is_array($person) ) {
                $this->encrypt_passwd = $person['encrypt_passwd'];
                $this->security_type = $person['security_type'];
            }

            return true;
        }
        catch (PDOException $e)
        {
            echo 'Query error.';
            die();
            return false;
        }        
    }    

    // call by tester check to change algorithm (another class)
    // dynamic binding for test only
    // method switchEncryptTypeUpdatePassword for real use
    // public function setEncryptType($etype){
    //     $this->security_type = $etype;
    //     if($this->getSecurityType()==1){
    //         $this->encrypt_strategy = new EncryptType1();
    //     } else if($this->getSecurityType()==2){
    //         $this->encrypt_strategy = new EncryptType2();
    //     }
    //     $this->encrypt_passwd = $this->performEncrypt();
    // }
}
?>