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

    /**
     * name tests
     **/

    public function testValidNameChars()
    {
        // arrange
        $name = "fefef";
        $invalidNameError = "Apenas letras e espaços em branco!";

        // act
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

    public function testValidNameLength()
    {
        // arrange
        $name = 'felizard';
        $invalidCharsError = "Apenas letras";
        $invalidLengthError = 'Numero invalido de characteres';

        // act
        $this->requiredData->setLength(8, $invalidLengthError);
        $nameData = $this->requiredData->validateName($name, $invalidCharsError);

        // assert
        $expectedNameData = [
            'name'  => $name,
            'error' => ''
        ];

        $this->assertSame($expectedNameData, $nameData);
    }

    public function testInvalidNameLength()
    {
        // arrange
        $name = 'felizard';
        $invalidCharsError = "Apenas letras";
        $invalidLengthError = 'Numero invalido de characteres';

        // act
        $this->requiredData->setLength(5, $invalidLengthError);
        $nameData = $this->requiredData->validateName($name, $invalidCharsError);

        // assert
        $expectedNameData = [
            'name'  => '',
            'error' => $invalidLengthError
        ];

        $this->assertSame($expectedNameData, $nameData);
    }
    
    public function testValidNameDelimitation()
    {
        // arrange
        $name = 'feliz';
        $invalidCharsError = "Apenas letras e espacos em branco";
        $delimitationError = 'caracteres de 4 a 8';

        // act
        $this->requiredData->setDelimitation(4, 8, $delimitationError);
        $nameData = $this->requiredData->validateName($name, $invalidCharsError);

        // assert
        $expectedNameData = [
            'name'  => $name,
            'error' => ''
        ];

        $this->assertSame($expectedNameData, $nameData);
    }

    public function testInvalidNameDelimitation()
    {
        // arrange
        $name = 'felizardo';
        $invalidCharsError = "Apenas letras e espacos em branco";
        $delimitationError = 'caracteres de 4 a 8';

        // act
        $this->requiredData->setDelimitation(4, 7, $delimitationError);
        $nameData = $this->requiredData->validateName($name, $invalidCharsError);

        // assert
        $expectedNameData = [
            'name'  => '',
            'error' => $delimitationError
        ];

        $this->assertSame($expectedNameData, $nameData);
    }

    public function testValidaNumber()
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

    public function testValidEmail()
    {
        // arrange
        $email = "felizardo@gmail.com";
        $invalidEmailError = "Formato inválido de email!";

        // act
        $emailData = $this->requiredData->validateEmail($email, $invalidEmailError);

        // assert
        $expectedContent = array(
            "email" => $email,
            "error" => ""
        );

        $this->assertSame($expectedContent, $emailData);
    }

    public function testInvalidEmail()
    {
        // arrange
        $email = "felizardo.com";
        $invalidEmailError = "Formato inválido de email!";

        // act
        $emailData = $this->requiredData->validateEmail($email, $invalidEmailError);

        // assert
        $expectedContent = array(
            "email" => '',
            "error" => $invalidEmailError,
        );

        $this->assertSame($expectedContent, $emailData);
    }

    public function testValidURL()
    {
        // arrange
        $url = "http://www.felizardo.com";
        $invalidemailError = "Formato inválido de url!";

        // act
        $urlData = $this->requiredData->validateUrl($url, $invalidemailError);

        // assert
        $expectedContent = array(
            "url"   => $url,
            "error" => ""
        );

        $this->assertSame($expectedContent, $urlData) ;
    }

    public function testInvalidURL()
    {
        // arrange
        $url = "://ww.felizardo";
        $invalidEmailError = "Formato inválido de url!";

        // act
        $urlData = $this->requiredData->validateUrl($url, $invalidEmailError);

        // assert
        $expectedContent = array(
            'url'   => '',
            'error' => $invalidEmailError,
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
