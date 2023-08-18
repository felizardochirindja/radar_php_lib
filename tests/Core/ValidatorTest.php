<?php

use PHPUnit\Framework\TestCase;
use Radar\Core\Validator;

require "../../vendor/autoload.php";

class ValidatorTest extends TestCase
{
    public function testIsNumberNegativeMustReturnTrue()
    {
        $validatorMock = $this->getMockForAbstractClass(Validator::class);
        $isNumberNegativeMethod = self::getPrivateMethod($validatorMock, 'isNumberNegative');
        
        $result = $isNumberNegativeMethod->invokeArgs($validatorMock, [-10]);

        $this->assertTrue($result);
    }

    public function testIsNumberNegativeMustReturnFalse()
    {
        $validatorMock = $this->getMockForAbstractClass(Validator::class);
        $isNumberNegativeMethod = self::getPrivateMethod($validatorMock, 'isNumberNegative');
        
        $result = $isNumberNegativeMethod->invokeArgs($validatorMock, [10]);

        $this->assertFalse($result);
    }

    public function testSanitizeDataMustReturnModifiedHtml()
    {
        $validatorMock = $this->getMockForAbstractClass(Validator::class);
        $sanitizeDataMethod = self::getPrivateMethod($validatorMock, 'sanitizeData');

        $result = $sanitizeDataMethod->invokeArgs($validatorMock, [' fsad<html> ']);

        $this->assertSame('fsad&lt;html&gt;', $result);
    }

    /**
     * returns a private method from the given class
     * 
     * @param object $className name of the class to get the method
     * @param $param string $methodName method to get
     * 
     * @return ReflectionMethod
    */
    protected static function getPrivateMethod(
        object $className,
        string $methodName
    ): ReflectionMethod
    {
        $class = new ReflectionClass($className::class);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }
}
