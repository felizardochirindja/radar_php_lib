<?php

use PHPUnit\Framework\TestCase;
use Radar\Core\Validator;

require "../../vendor/autoload.php";

class ValidatorTest extends TestCase
{
    public function testIsNumberNegative() {
        // arrange
        $validatorMock = $this->getMockForAbstractClass(Validator::class);
        $isNumberNegativeMethod = self::getPrivateMethod($validatorMock, 'isNumberNegative');
        
        // act
        $result = $isNumberNegativeMethod->invokeArgs($validatorMock, [-10]);

        // assert
        $this->assertTrue($result);
    }

    public function testSanitizeData() {

    }

    protected static function getPrivateMethod(
        object $className,
        string $methodName
    ) : ReflectionMethod
    {
        $class = new ReflectionClass($className::class);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }
}
