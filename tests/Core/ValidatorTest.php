<?php

use PHPUnit\Framework\TestCase;
use Radar\Core\DataFilter;
use Radar\Core\DataLimiter;
use Radar\Core\Validator;

require __DIR__ . "/../../vendor/autoload.php";

class ValidatorTest extends TestCase
{
    /** @test */
    public function itShouldReturnTrueIfTheNumberIsNegative()
    {
        $validatorMock = $this->getMockForAbstractClass(Validator::class, [new DataLimiter]);
        $isNumberNegativeMethod = self::getPrivateMethod($validatorMock, 'isNumberNegative');
        
        $result = $isNumberNegativeMethod->invokeArgs($validatorMock, [-10]);

        $this->assertTrue($result);
    }

    /** @test */
    public function itShouldReturnFalseIfTheNumberIsPositive()
    {
        $validatorMock = $this->getMockForAbstractClass(Validator::class, [new DataLimiter]);
        $isNumberNegativeMethod = self::getPrivateMethod($validatorMock, 'isNumberNegative');
        
        $result = $isNumberNegativeMethod->invokeArgs($validatorMock, [10]);

        $this->assertFalse($result);
    }

    public function testSanitizeDataMustReturnModifiedHtml()
    {
        $validatorMock = $this->getMockForAbstractClass(Validator::class, [new DataLimiter]);
        $sanitizeDataMethod = self::getPrivateMethod($validatorMock, 'sanitizeData');

        $result = $sanitizeDataMethod->invokeArgs($validatorMock, [' fsad<html> ']);

        $this->assertSame('fsad&lt;html&gt;', $result);
    }

    public function testFilterDataByFilters()
    {
        $validatorMock = $this->getMockForAbstractClass(Validator::class, [new DataLimiter]);
        $sanitizeDataMethod = self::getPrivateMethod($validatorMock, 'filterDataByFilters');

        $sanitizeDataMethod->invoke($validatorMock, 'felix@gmail.com', DataFilter::Email);

        $reflection = new ReflectionClass($validatorMock);

        $validDataProperty = $reflection->getProperty('validData');
        $validDataProperty->setAccessible(true);
        $validaDataValue = $validDataProperty->getValue($validatorMock);

        $invalidDataErrorProperty = $reflection->getProperty('invalidDataError');
        $invalidDataErrorProperty->setAccessible(true);
        $invalidDataErrorValue = $invalidDataErrorProperty->getValue($validatorMock);

        $this->assertSame('felix@gmail.com', $validaDataValue);
        $this->assertSame('', $invalidDataErrorValue);
    }

    /**
     * returns a private method from the given class
     * 
     * @param object $className name of the class to get the method
     * @param $param string $methodName method to get
     * 
     * @return ReflectionMethod
    */
    protected static function getPrivateMethod(object $className, string $methodName): ReflectionMethod
    {
        $class = new ReflectionClass($className::class);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }
}
