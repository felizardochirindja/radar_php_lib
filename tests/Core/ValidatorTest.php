<?php

use PHPUnit\Framework\TestCase;
use Radar\Core\Validator;

require "../../vendor/autoload.php";

class ValidatorTest extends TestCase
{
    public function isNumberNegativeTest() {
        // arrange
        $validatorMock = $this->getMockForAbstractClass(Validator::class);
        $isNumberNegativeMethod = self::getPrivateMethod($validatorMock, 'isNumberNegative');
        
        
    }

    public function sanitizeDataTest() {

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
