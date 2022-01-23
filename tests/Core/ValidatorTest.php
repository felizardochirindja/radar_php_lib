<?php

use PHPUnit\Framework\TestCase;
use Radar\Core\Validator;

require "../../vendor/autoload.php";

class ValidatorTest extends TestCase
{
    public function testFilterSanitizedName()
    {
        // arrange
        $validatorMock = $this->getMockForAbstractClass(Validator::class);
        $filterSanitizedNameMethod = self::getMethod($validatorMock, 'filterSanitizedName');

        // act
        $filterSanitizedNameMethod->invokeArgs($validatorMock, ['Felizardo']);

        // assert

    }

    protected static function getMethod(
        object $className,
        string $methodName
    ) : ReflectionMethod
    {
        $class = new ReflectionClass($className::class);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    private static function getPrivateProperty(
        object $className,
        string $propertyName
    ) : ReflectionProperty
    {
        $class = new ReflectionClass($className::class);
        $property = $class->getProperty($propertyName);
        $property->setAccessible(true);

        return $property;
    }
}
