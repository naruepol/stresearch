<?php declare(strict_types=1);
// Tester Test
include "Person.php";
include "Connect.php";
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase {
    private $con;
    private $p1;

    public function setUp():void {
        $this->con = new connectDB();
        $this->p1 = new Person($this->con->connect());
    }
    
    //for test only (used getXXX) before run disable $this->insertUser(); in setDataToInsertAccount
    // public function testCreationObject(){
    //     $this->p1->setDataToInsertAccount("2166","Somchai","somchai@myresearch.com","test","2");
    //     $this->assertEquals("2166",$this->p1->getUid());
    //     $this->assertEquals("Somchai",$this->p1->getName());
    //     $this->assertEquals("somchai@myresearch.com",$this->p1->getUserEmail());
    //     $this->assertEquals("test",$this->p1->getPassword());
    //     $this->assertEquals("2",$this->p1->getSecurityType());
    // }

    //for test only (used getXXX) before run disable $this->insertUser(); in setDataToInsertAccount
    // public function testEncryptionType1(){
    //     $this->p1->setDataToInsertAccount("2166","Somchai","somchai@myresearch.com","test","1");
    //     $this->assertTrue(password_verify($this->p1->getPassword(), $this->p1->getEncryptPassword()));
    // }

    // //for test only (used getXXX) before run diable $this->insertUser(); in setDataToInsertAccount
    // public function testEncryptionType2(){
    //     $this->p1->setDataToInsertAccount("2166","Somchai","somchai@myresearch.com","test","2");
    //     $this->assertTrue(md5($this->p1->getPassword()) == $this->p1->getEncryptPassword());
    // }

    //for test only (used getXXX) before run disable $this->insertUser(); in setDataToInsertAccount
    // public function testChangingEncrptionType(){
    //     $this->p1->setDataToInsertAccount("2166","Somchai","somchai@myresearch.com","test","1");
    //     $this->assertTrue(password_verify($this->p1->getPassword(), $this->p1->getEncryptPassword()));
    //     $this->p1->setEncryptType("2");
    //     $this->assertFalse(password_verify($this->p1->getPassword(), $this->p1->getEncryptPassword()));
    //     $this->assertTrue(md5($this->p1->getPassword()) == $this->p1->getEncryptPassword());
    // }

    public function testCheckingLogin(){
        $this->assertTrue($this->p1->checkLogin("somchai@myresearch.com","test"));
        $this->assertTrue($this->p1->checkLogin("somsak@myresearch.com","test"));
    }

    // public function testAddingAccount(){
    //     $this->assertTrue($this->p1->setDataToInsertAccount("2499","Kasem","kasem@myreseach.com","bandit","1"));
    //     $this->assertTrue($this->p1->checkLogin("kasem@myreseach.com","bandit"));
    // }

    // public function testChangingSecurity(){
    //     $this->assertTrue($this->p1->switchEncryptTypeUpdatePassword("2","2167","secret"));
    //     $this->assertTrue($this->p1->checkLogin("somsak@myresearch.com","secret"));
    // }
}