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
            "name"  => $name,
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
            "name"  => '',
            "error" => $invalidNameError,
        ];

        $this->assertSame($expectedContent, $nameData);
    }

    function testValidateNumber()
    {
        // arrange
        $number = "55";
        $invalidNumberError = "Apenas números!";
        // $invalidLengthError = "Digite apenas 4 caracteres!";
        $limitCharsError = "Digite de 2 a 4 caracteres apenas!";
        $negativeNumberError = 'apenas números positivos!';

        // act
        $this->nonRequiredData->denyNegativeNumber($negativeNumberError);
        $this->nonRequiredData->setDelimitation(2, 4, $limitCharsError);
        // $this->data->useLength(5, $invalidLengthError);
        $numberData = $this->nonRequiredData->validateNumber($number, $invalidNumberError);

        // assert
        $expectedContent = array(
            'number' => (int) $number,
            'error'  => ""
        );

        $this->assertSame($expectedContent, $numberData);
    }

    function testValidateEmail()
    {
        // arrange
        $email = "felizardo@gmail.com";
        $error = "Formato inválido de email!";

        // act
        $emailData = $this->nonRequiredData->validateEmail($email, $error);

        // assert
        $expectedContent = array(
            "email" => $email,
            "error" => ""
        );

        $this->assertSame($expectedContent, $emailData);
    }

    function testValidateURL()
    {
        // arrange
        $url = "https://www.felizardo.com";
        $invalidemailError = "Formato inválido de url!";

        // act
        $urlData = $this->nonRequiredData->validateUrl($url, $invalidemailError);

        // assert
        $expectedContent = array(
            "url"   => $url,
            "error" => ""
        );

        $this->assertSame($expectedContent, $urlData) ;
    }

    function testValidateString()
    {
        // arrange
        $string = "";
        $invalidLengthError = "Digite apenas 4 caracteres!";
        // $limitCharsError = "Digite de 5 a 10 caracteres apenas!";

        // act
        // $this->data->limitChars(5, 10, $limitCharsError);
        $this->nonRequiredData->setLength(4, $invalidLengthError);
        $stringData = $this->nonRequiredData->validatestring($string);

        // assert
        $expectedContent = array(
            "chars" => $string,
            "error" => ""
        );

        $this->assertSame($expectedContent, $stringData);
    }

    function testValidateEmptyData()
    {
        $emptyData = $this->nonRequiredData->validateEmptyData('', 'name');
        $expectedData = [
            'name' => '',
            'error' => '',
        ];

        $this->assertSame($expectedData, $emptyData);
    }

    /** @test */
    function validateEmptyDataShouldReturnFalseIfGivenDataIsNotEmpty()
    {
        $result = $this->nonRequiredData->validateEmptyData('f', 'name');
        $this->assertFalse($result);
    }
}
