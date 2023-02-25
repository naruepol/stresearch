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
    //for test only (used getXXX)
    public function testCreateObject(){
        $this->p1->setDataToInsertAccount("2166","Somchai","somchai@myresearch.com","test","2");
        $this->assertEquals("2166",$this->p1->getUid());
        $this->assertEquals("Somchai",$this->p1->getName());
        $this->assertEquals("somchai@myresearch.com",$this->p1->getUserEmail());
        $this->assertEquals("test",$this->p1->getPassword());
        $this->assertEquals("2",$this->p1->getSecurityType());
    }

    //for test only (used getXXX)
    public function testEncryptionType1(){
        $this->p1->setDataToInsertAccount("2166","Somchai","somchai@myresearch.com","test","1");
        $this->assertTrue(password_verify($this->p1->getPassword(), $this->p1->getEncryptPassword()));
    }

    // //for test only (used getXXX)
    public function testEncryptionType2(){
        $this->p1->setDataToInsertAccount("2166","Somchai","somchai@myresearch.com","test","2");
        $this->assertTrue(md5($this->p1->getPassword()) == $this->p1->getEncryptPassword());
    }

    // //for test only (used getXXX)
    public function testChangeEncrptionType(){
        $this->p1->setDataToInsertAccount("2166","Somchai","somchai@myresearch.com","test","1");
        $this->assertTrue(password_verify($this->p1->getPassword(), $this->p1->getEncryptPassword()));
        $this->p1->setEncryptType("2");
        $this->assertFalse(password_verify($this->p1->getPassword(), $this->p1->getEncryptPassword()));
        $this->assertTrue(md5($this->p1->getPassword()) == $this->p1->getEncryptPassword());
    }

    public function testCheckLogin(){
        $this->p1->setDataToInsertAccount("2166","Somchai","somchai@myresearch.com","test","1");
        $this->assertTrue($this->p1->checkLogin("somchai@myresearch.com","test"));
    }
}