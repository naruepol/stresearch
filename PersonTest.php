<?php declare(strict_types=1);
// Tester Test
include "Person.php";
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase {

    public function testCreateObject(){
        $p1 = new Person("2166","Somchai","somchai@myresearch.com","test","1");
        $this->assertEquals("2166",$p1->getUid());
        $this->assertEquals("Somchai",$p1->getName());
        $this->assertEquals("somchai@myresearch.com",$p1->getUserEmail());
        $this->assertEquals("test",$p1->getPassword());
        $this->assertEquals("1",$p1->getSecurityType());
    }

    public function testEncryptionType1(){
        $p1 = new Person("2166","Somchai","U01","somchai@myresearch.com","1");
        $this->assertTrue(password_verify($p1->getPassword(), $p1->getEncryptPassword()));
    }

    public function testEncryptionType2(){
        $p1 = new Person("2166","Somchai","U01","somchai@myresearch.com","2");
        $this->assertTrue(md5($p1->getPassword()) == $p1->getEncryptPassword());
    }

    public function testChangeEncrptionType(){
        $p1 = new Person("2166","Somchai","U01","somchai@myresearch.com","1");
        $this->assertTrue(password_verify($p1->getPassword(), $p1->getEncryptPassword()));
        $p1->setEncryptType("2");
        $this->assertFalse(password_verify($p1->getPassword(), $p1->getEncryptPassword()));
        $this->assertTrue(md5($p1->getPassword()) == $p1->getEncryptPassword());
    }
}