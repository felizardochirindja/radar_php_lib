<?php

require __DIR__ . "/../../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use Radar\Core\DataLimiter;

class DataLimiterTest extends TestCase
{
    public function testSetDefaultConfiguration()
    {
        $dataLimiter = new DataLimiter();
        $reflectionClass = new ReflectionClass($dataLimiter::class);

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

        $this->assertTrue($useDelimitationValue);
        $this->assertEquals(1, $minCharsValue);
        $this->assertEquals(50, $maxCharsValue);
    }

    /** @test */
    public function dataShouldBeProperlyLimited()
    {
        $dataLimiter = new DataLimiter();
        $reflectionClass = new ReflectionClass($dataLimiter::class);

        $data = 'ff';

        $minCharsProperty = $reflectionClass->getProperty('minChars');
        $minCharsProperty->setAccessible(true);
        $minCharsProperty->setValue($dataLimiter, 2);

        $maxCharsProperty = $reflectionClass->getProperty('maxChars');
        $maxCharsProperty->setAccessible(true);
        $maxCharsProperty->setValue($dataLimiter, 5);

        $isProperlyLimited = $dataLimiter->isProperlyLimited($data);

        $dataLimiter->setDelimitation(2, 5, '');

        $this->assertTrue($isProperlyLimited);
    }

    public function testSetDelimitation()
    {
        $dataLimiter = new DataLimiter();
        $reflectionClass = new ReflectionClass($dataLimiter::class);

        $minChars = 2;
        $maxChars = 4;
        $error = 'Digite entre 2 a 4 caracteres!';

        $dataLimiter->setDelimitation($minChars, $maxChars, $error);

        $minCharsProperty = $reflectionClass->getProperty('minChars');
        $minCharsProperty->setAccessible(true);
        $minCharsValue = $minCharsProperty->getValue($dataLimiter);

        $maxCharsProperty = $reflectionClass->getProperty('maxChars');
        $maxCharsProperty->setAccessible(true);
        $maxCharsValue = $maxCharsProperty->getValue($dataLimiter);

        $useDelimitationProperty = $reflectionClass->getProperty('useDelimitation');
        $useDelimitationProperty->setAccessible(true);
        $useDelimitationValue = $useDelimitationProperty->getValue($dataLimiter);

        $this->assertSame($error, $dataLimiter->error);
        $this->assertEquals($minChars, $minCharsValue);
        $this->assertEquals($maxChars, $maxCharsValue);
        $this->assertTrue($useDelimitationValue);
    }

    public function testSetLength()
    {
        $dataLimiter = new DataLimiter();
        $reflectionClass = new ReflectionClass($dataLimiter::class);

        $data = 'Felix';
        $length = 5;
        $error = 'Apenas 5 caracteres!';

        $dataLimiter->setLength($length, $error);

        $charsNumberProperty = $reflectionClass->getProperty('charsNumber');
        $charsNumberProperty->setAccessible(true);
        $charsNumberValue = $charsNumberProperty->getValue($dataLimiter);

        $useDelimitationProperty = $reflectionClass->getProperty('useDelimitation');
        $useDelimitationProperty->setAccessible(true);
        $useDelimitationValue = $useDelimitationProperty->getValue($dataLimiter);

        $this->assertSame($error, $dataLimiter->error);
        $this->assertEquals($length, $charsNumberValue);
        $this->assertFalse($useDelimitationValue);
    }
}
