<?php

require "../../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use Radar\Core\DataLimiter;

class DataLimiterTest extends TestCase
{
    public function testSetDefaultConfiguration()
    {
        // arange
        $dataLimiter = new DataLimiter();
        $reflectionClass = new ReflectionClass($dataLimiter::class);

        // act
        $dataLimiter->setDefaultConfiguration();

        $minCharsProperty = $reflectionClass->getProperty('minChars');
        $minCharsProperty->setAccessible(true);
        $minCharsValue = $minCharsProperty->getValue($dataLimiter);

        $maxCharsProperty = $reflectionClass->getProperty('maxChars');
        $maxCharsProperty->setAccessible(true);
        $maxCharsValue = $maxCharsProperty->getValue($dataLimiter);

        $useDelimitationProperty = $reflectionClass->getProperty('useDelimitation');
        $useDelimitationProperty->setAccessible(true);
        $useDelimitationValue = $useDelimitationProperty->getValue($dataLimiter);

        // assert
        $this->assertTrue($useDelimitationValue);
        $this->assertEquals(1, $minCharsValue);
        $this->assertEquals(50, $maxCharsValue);
    }

    public function testIsProperlyLimited()
    {
        // arange
        $dataLimiter     = new DataLimiter();
        $reflectionClass = new ReflectionClass($dataLimiter::class);

        $data = 'ffff';

        // act
        $minCharsProperty = $reflectionClass->getProperty('minChars');
        $minCharsProperty->setAccessible(true);
        $minCharsProperty->setValue($dataLimiter, 2);

        $maxCharsProperty = $reflectionClass->getProperty('maxChars');
        $maxCharsProperty->setAccessible(true);
        $maxCharsProperty->setValue($dataLimiter, 5);

        // simulando o metodo useLength();
        // $useDelimitationProperty = $reflectionClass->getProperty('useDelimitation');
        // $useDelimitationProperty->setAccessible(true);
        // $useDelimitationProperty->setValue($dataLimiter, false);

        // $charsNumberProperty = $reflectionClass->getProperty('charsNumber');
        // $charsNumberProperty->setAccessible(true);
        // $charsNumberProperty->setValue($dataLimiter, 5);

        // principal action
        $isProperlyLimited = $dataLimiter->isProperlyLimited($data);

        // assert
        $this->assertTrue($isProperlyLimited);
    }

    public function testSetDelimitation()
    {
        // arange
        $dataLimiter     = new DataLimiter();
        $reflectionClass = new ReflectionClass($dataLimiter::class);

        $minChars = 2;
        $maxChars = 4;
        $error    = 'Digite entre 2 a 4 caracteres!';
        
        // act
        $dataLimiter->setDelimitation($minChars, $maxChars, $error);

        $minCharsProperty = $reflectionClass->getProperty('minChars');
        $minCharsProperty->setAccessible(true);
        $minCharsValue    = $minCharsProperty->getValue($dataLimiter);

        $maxCharsProperty = $reflectionClass->getProperty('maxChars');
        $maxCharsProperty->setAccessible(true);
        $maxCharsValue    = $maxCharsProperty->getValue($dataLimiter);

        $useDelimitationProperty = $reflectionClass->getProperty('useDelimitation');
        $useDelimitationProperty->setAccessible(true);
        $useDelimitationValue = $useDelimitationProperty->getValue($dataLimiter);

        // assert
        $this->assertSame($error, $dataLimiter->error);
        $this->assertEquals($minChars, $minCharsValue);
        $this->assertEquals($maxChars, $maxCharsValue);
        $this->assertTrue($useDelimitationValue);
    }

    public function testSetLength()
    {
        // arange
        $dataLimiter     = new DataLimiter();
        $reflectionClass = new ReflectionClass($dataLimiter::class);

        $data   = 'Felix';
        $length = 5;
        $error  = 'Apenas 5 caracteres!';

        // act
        $dataLimiter->setLength($length, $error);

        $charsNumberProperty = $reflectionClass->getProperty('charsNumber');
        $charsNumberProperty->setAccessible(true);
        $charsNumberValue = $charsNumberProperty->getValue($dataLimiter);

        $useDelimitationProperty = $reflectionClass->getProperty('useDelimitation');
        $useDelimitationProperty->setAccessible(true);
        $useDelimitationValue = $useDelimitationProperty->getValue($dataLimiter);

        // assert
        $this->assertSame($error, $dataLimiter->error);
        $this->assertEquals($length, $charsNumberValue);
        $this->assertFalse($useDelimitationValue);
    }
}
