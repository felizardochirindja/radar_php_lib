<?php

require "../../vendor/autoload.php";

use Radar\Validators\NonRequiredData;
use PHPUnit\Framework\TestCase;

class NonRequiredDataTest extends TestCase
{
    private NonRequiredData $nonRequiredData;

    public function __construct()
    {
        parent::__construct();
        $this->nonRequiredData = new NonRequiredData();
    }

    public function testValidateName()
    {
        // arrange
        $name = "fffff";
        $invalidNameError = "Apenas letras e espaços em branco!";
        $invalidLengthError = "Digite apenas 5 caracteres!";
        $limitCharsError = "Digite de 4 a 6 caracteres apenas!";

        // act
        // $this->nonRequiredData->setLength(5, $invalidLengthError);
        $this->nonRequiredData->setDelimitation(4, 6, $limitCharsError);
        $nameData = $this->nonRequiredData->validateName($name, $invalidNameError);

        // assert
        $expectedContent = array(
            "name"  => $name,
            "error" => ""
        );

        $this->assertSame($expectedContent, $nameData);
    }

    public function testValidateNumber()
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

    public function testValidateEmail()
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

    public function testValidateURL()
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

    public function testValidateString()
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
}
