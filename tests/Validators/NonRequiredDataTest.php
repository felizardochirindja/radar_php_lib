<?php

require  __DIR__ . "/../../vendor/autoload.php";

use Radar\Validators\NonRequiredData;
use PHPUnit\Framework\TestCase;
use Radar\Core\DataLimiter;
use Radar\Core\DataPattern;
use Radar\Validators\DataType;

class NonRequiredDataTest extends TestCase
{
    private NonRequiredData $nonRequiredData;

    public function __construct()
    {
        parent::__construct();
        $this->nonRequiredData = new NonRequiredData(new DataLimiter);
    }

    /** @test */
    public function theNameCharactersShouldBeValid()
    {
        $name = "fffff";
        $invalidNameError = "Apenas letras e espaços em branco!";

        $nameData = $this->nonRequiredData->validateName($name, $invalidNameError);

        $expectedContent = [
            "name" => $name,
            "error" => "",
        ];

        $this->assertSame($expectedContent, $nameData);
    }

    /** @test */
    public function theNameCharactersShouldBeInvalid()
    {
        $name = "fffff0";
        $invalidNameError = "Apenas letras e espaços em branco!";

        $nameData = $this->nonRequiredData->validateName($name, $invalidNameError);

        $expectedContent = [
            "name" => '',
            "error" => $invalidNameError,
        ];

        $this->assertSame($expectedContent, $nameData);
    }

    /** @test */
    public function numberShouldBeValidIfNumericStringIsPassed()
    {
        $number = "55";
        $error = "Apenas números!";
        
        $numberData = $this->nonRequiredData->validateNumber($number, $error);

        $expectedData = [
            'number' => (int) $number,
            'error' => ""
        ];

        $this->assertSame($expectedData, $numberData);
    }

    /** @test */
    public function numberShouldBeValidIfIntegerIsPassed()
    {
        $number = 55;
        $error = "Apenas números!";
        
        $numberData = $this->nonRequiredData->validateNumber($number, $error);

        $expectedData = [
            'number' => $number,
            'error' => ""
        ];

        $this->assertSame($expectedData, $numberData);
    }

    /** @test */
    public function numberShouldBeInvalid()
    {
        $number = "55f";
        $error = "Apenas números!";
        
        $numberData = $this->nonRequiredData->validateNumber($number, $error);

        $expectedData = [
            'number' => '',
            'error' => $error,
        ];

        $this->assertSame($expectedData, $numberData);
    }

    /** @test */
    public function numberShouldNotBeNegative()
    {
        $number = -55;
        $error = '';
        $numberNegativeError = 'numero nao pode ser negativo!';

        $this->nonRequiredData->denyNegativeNumber($numberNegativeError);
        $numberData = $this->nonRequiredData->validateNumber($number, $error);

        $expectedData = [
            'number' => '',
            'error' => $numberNegativeError,
        ];

        $this->assertSame($expectedData, $numberData);
    }

    /** @test */
    public function theEmailShouldBeValid()
    {
        $email = "felizardo@gmail.com";
        $error = "Formato inválido de email!";

        $emailData = $this->nonRequiredData->validateEmail($email, $error);

        $expectedContent = [
            "email" => $email,
            "error" => ""
        ];

        $this->assertSame($expectedContent, $emailData);
    }

    /** @test */
    public function theEmailShouldBeInvalid()
    {
        $email = "felizardo@gmail";
        $error = "Formato inválido de email!";

        $emailData = $this->nonRequiredData->validateEmail($email, $error);

        $expectedContent = [
            "email" => '',
            "error" => $error,
        ];

        $this->assertSame($expectedContent, $emailData);
    }

    /** @test */
    public function theUrlShouldBeValid()
    {
        $url = "https://www.felizardo.com";
        $invalidemailError = "Formato inválido de url!";

        $urlData = $this->nonRequiredData->validateUrl($url, $invalidemailError);

        $expectedContent = [
            "url" => $url,
            "error" => ""
        ];

        $this->assertSame($expectedContent, $urlData);
    }

    /** @test */
    public function theUrlShouldBeInvalid()
    {
        $url = "felizardo.com";
        $error = "Formato inválido de url!";

        $urlData = $this->nonRequiredData->validateUrl($url, $error);

        $expectedContent = [
            "url" => '',
            "error" => $error,
        ];

        $this->assertSame($expectedContent, $urlData);
    }

    /** @test */
    public function emptyDataShouldReturnArrayIfGivenDataIsEmpty()
    {
        $emptyData = $this->nonRequiredData->validateEmptyData('', DataType::NAME);
        
        $expectedData = [
            'name' => '',
            'error' => '',
        ];

        $this->assertSame($expectedData, $emptyData);
    }

    /** @test */
    public function emptyDataShouldReturnFalseIfGivenDataIsNotEmpty()
    {
        $result = $this->nonRequiredData->validateEmptyData('f', DataType::NAME);
        $this->assertFalse($result);
    }

    /** @test */
    public function stringShouldMatchTheGivenPatern()
    {
        $pattern = new DataPattern(2, 2, 1);
        
        $result = $this->nonRequiredData->validateString('aA#1', $pattern, 'string doesnt match the pattern');

        $expectedData = [
            'chars' => 'aA#1',
            'error' => '',
        ];

        $this->assertSame($expectedData, $result);
    }

    /** @test */
    public function itShouldThrowExceptionIfPatternDataQuantityIsDiferentToStringDelimitation()
    {
        $pattern = new DataPattern(2, 1, 1);
        
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('pattern data quantity must not be greater to string delimitation');

        $this->nonRequiredData->setLength(3, '');
        $this->nonRequiredData->validateString('aA#1', $pattern, 'string doesnt match the pattern');
    }
}
