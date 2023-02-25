<?php declare(strict_types=1);
include "Calculator.php";
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase {
    private $cal1;

    public function setUp():void {
        $this->cal = new Calculator();
    }

    public function testAdd1(){
        $this->assertEquals(5,$this->cal->add(4,1));
    }
    
}