<?php

require "../../vendor/autoload.php";

use Radar\Validators\RequiredData;
use PHPUnit\Framework\TestCase;

class RequiredDataTest extends TestCase
{
    private RequiredData $requiredData;
    private const REQUIRED_DATA_ERROR = "Campo obrigratório!";

    public function __construct()
    {
        parent::__construct();
        $this->requiredData = new RequiredData(self::REQUIRED_DATA_ERROR);
    }

    public function testValidNameChars()
    {
        // arrange
        $name = "fefef";
        $invalidNameError = "Apenas letras e espaços em branco!";
        $invalidLengthError = "Digite apenas 5 caracteres!";
        $limitCharsError = "Digite de 5 a 10 caracteres apenas!";
        // $requiredNameError = "O nome é obrigatório!";

        // act
        $this->requiredData->setLength(5, $invalidLengthError);
        // $this->data->limitChars(5, 10, $limitCharsError);
        $nameData = $this->requiredData->validateName($name, $invalidNameError);

        // assert
        $expectedContent = array(
            "name"  => $name,
            "error" => ""
        );

        $this->assertSame($expectedContent, $nameData);
    }

    public function testInvalidNameChars()
    {
        // arrange
        $name = "ffe5";
        $invalidCharsError = "Apenas letras";

        // act
        $nameData = $this->requiredData->validateName($name, $invalidCharsError);

        // assert
        $expetedNameData = [
            'name'  => '',
            'error' => $invalidCharsError
        ];

        $this->assertSame($expetedNameData, $nameData);
    }

    public function testValidateNumber()
    {
        // arrange
        $number = 44444;
        $invalidNumberError = "Apenas números!";
        $invalidLengthError = "Digite apenas 5 caracteres!";
        $limitCharsError = "Digite de 5 a 10 caracteres apenas!";
        // $requiredNumberError = "O número é obrigatório!";

        // act
        $this->requiredData->setDelimitation(5, 10, $limitCharsError);
        $numberData = $this->requiredData->validateNumber($number, $invalidNumberError);

        // assert
        $expectedContent = array(
            "number" => $number,
            "error"  => ""
        );

        $this->assertSame($expectedContent, $numberData);
    }

    public function testValidateEmail()
    {
        // arrange
        $email = "felizardo@gmail.com";
        $invalidEmailError = "Formato inválido de email!";
        // $requiredEmailError = "O nome é obrigatório!";

        // act
        $emailData = $this->requiredData->validateEmail($email, $invalidEmailError);

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
        $url = "http://www.felizardo.com";
        $invalidemailError = "Formato inválido de url!";
        // $requiredUrlError = "A URL é obrigatória!";

        // act
        $urlData = $this->requiredData->validateUrl($url, $invalidemailError);

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
        $string = "abcd123=";
        // $invalidLengthError = "Digite apenas 4 caracteres!";
        // $limitCharsError = "Digite de 5 a 10 caracteres apenas!";
        // $requiredStringError = "A string é obrigatória!";

        // act
        $stringData = $this->requiredData->validatestring($string);

        // assert
        $expectedContent = array(
            "chars" => $string,
            "error" => ""
        );

        $this->assertSame($expectedContent, $stringData);
    }
}
