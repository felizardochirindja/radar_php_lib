<?php

require  __DIR__ . "/../../vendor/autoload.php";

use Radar\Validators\NonRequiredData;
use PHPUnit\Framework\TestCase;

class NonRequiredDataTest extends TestCase
{
    private NonRequiredData $nonRequiredData;

    function __construct()
    {
        parent::__construct();
        $this->nonRequiredData = new NonRequiredData();
    }

    /** @test */
    function theNameCharactersShoulbBeValid()
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
    function theNameCharactersShoulbBeInvalid()
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
    function numberShouldBeValidIfNumericStringIsPassed()
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
    function numberShouldBeValidIfIntegerIsPassed()
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
    function numberShouldBeInvalid()
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
    function numberShouldNotBeNegative()
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
    function theEmailShouldBeValid()
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
    function theEmailShouldBeInvalid()
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
    function theUrlShouldBeValid()
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
    function theUrlShouldBeInvalid()
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
    function emptyDataShouldReturnArrayIfGivenDataIsEmpty()
    {
        $emptyData = $this->nonRequiredData->validateEmptyData('', 'name');
        
        $expectedData = [
            'name' => '',
            'error' => '',
        ];

        $this->assertSame($expectedData, $emptyData);
    }

    /** @test */
    function emptyDataShouldReturnFalseIfGivenDataIsNotEmpty()
    {
        $result = $this->nonRequiredData->validateEmptyData('f', 'name');
        $this->assertFalse($result);
    }
}
