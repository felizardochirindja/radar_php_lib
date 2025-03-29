<?php

require __DIR__ . "/../../vendor/autoload.php";

use Radar\Validators\RequiredData;
use PHPUnit\Framework\TestCase;
use Radar\Core\DataLimiter;
use Radar\Core\DataPattern;

class RequiredDataTest extends TestCase
{
    private RequiredData $requiredData;
    private const REQUIRED_DATA_ERROR = "Campo obrigratório!";

    public function __construct()
    {
        parent::__construct();
        $this->requiredData = new RequiredData(self::REQUIRED_DATA_ERROR, new DataLimiter);
    }

    public function testValidNameChars()
    {
        $name = "fefef";
        $invalidNameError = "Apenas letras e espaços em branco!";

        $nameData = $this->requiredData->validateName($name, $invalidNameError);

        $expectedContent = array(
            "name" => $name,
            "error" => ""
        );

        $this->assertSame($expectedContent, $nameData);
    }

    public function testInvalidNameChars()
    {
        $name = "ffe5";
        $invalidCharsError = "Apenas letras";

        $nameData = $this->requiredData->validateName($name, $invalidCharsError);

        $expetedNameData = [
            'name' => '',
            'error' => $invalidCharsError
        ];

        $this->assertSame($expetedNameData, $nameData);
    }

    public function testValidNameLength()
    {
        $name = 'felizard';
        $invalidCharsError = "Apenas letras";
        $invalidLengthError = 'Numero invalido de characteres';

        $this->requiredData->setLength(8, $invalidLengthError);
        $nameData = $this->requiredData->validateName($name, $invalidCharsError);

        $expectedNameData = [
            'name' => $name,
            'error' => ''
        ];

        $this->assertSame($expectedNameData, $nameData);
    }

    public function testInvalidNameLength()
    {
        $name = 'felizard';
        $invalidCharsError = "Apenas letras";
        $invalidLengthError = 'Numero invalido de characteres';

        $this->requiredData->setLength(5, $invalidLengthError);
        $nameData = $this->requiredData->validateName($name, $invalidCharsError);

        $expectedNameData = [
            'name' => '',
            'error' => $invalidLengthError
        ];

        $this->assertSame($expectedNameData, $nameData);
    }

    public function testValidNameDelimitation()
    {
        $name = 'feliz';
        $invalidCharsError = "Apenas letras e espacos em branco";
        $delimitationError = 'caracteres de 4 a 8';

        $this->requiredData->setDelimitation(4, 8, $delimitationError);
        $nameData = $this->requiredData->validateName($name, $invalidCharsError);

        $expectedNameData = [
            'name' => $name,
            'error' => ''
        ];

        $this->assertSame($expectedNameData, $nameData);
    }

    public function testInvalidNameDelimitation()
    {
        $name = 'felizardo';
        $invalidCharsError = "Apenas letras e espacos em branco";
        $delimitationError = 'caracteres de 4 a 8';

        $this->requiredData->setDelimitation(4, 7, $delimitationError);
        $nameData = $this->requiredData->validateName($name, $invalidCharsError);

        $expectedNameData = [
            'name' => '',
            'error' => $delimitationError
        ];

        $this->assertSame($expectedNameData, $nameData);
    }

    public function testValidaNumber()
    {
        $number = 44444;
        $invalidNumberError = "Apenas números!";
        $limitCharsError = "Digite de 5 a 10 caracteres apenas!";

        $this->requiredData->setDelimitation(5, 10, $limitCharsError);
        $numberData = $this->requiredData->validateNumber($number, $invalidNumberError);

        $expectedContent = array(
            "number" => $number,
            "error"  => ""
        );

        $this->assertSame($expectedContent, $numberData);
    }

    public function testValidEmail()
    {
        $email = "felizardo@gmail.com";
        $invalidEmailError = "Formato inválido de email!";

        $emailData = $this->requiredData->validateEmail($email, $invalidEmailError);

        $expectedContent = array(
            "email" => $email,
            "error" => ""
        );

        $this->assertSame($expectedContent, $emailData);
    }

    public function testInvalidEmail()
    {
        $email = "felizardo.com";
        $invalidEmailError = "Formato inválido de email!";

        $emailData = $this->requiredData->validateEmail($email, $invalidEmailError);

        $expectedContent = array(
            "email" => '',
            "error" => $invalidEmailError,
        );

        $this->assertSame($expectedContent, $emailData);
    }

    public function testValidUrl()
    {
        $url = "http://www.felizardo.com";
        $invalidemailError = "Formato inválido de url!";

        $urlData = $this->requiredData->validateUrl($url, $invalidemailError);

        $expectedContent = array(
            "url" => $url,
            "error" => ""
        );

        $this->assertSame($expectedContent, $urlData);
    }

    public function testInvalidUrl()
    {
        $url = "://ww.felizardo";
        $invalidEmailError = "Formato inválido de url!";

        $urlData = $this->requiredData->validateUrl($url, $invalidEmailError);

        $expectedContent = array(
            'url' => '',
            'error' => $invalidEmailError,
        );

        $this->assertSame($expectedContent, $urlData);
    }

    public function testValidateString()
    {
        $string = "abcd123=";
        $pattern = new DataPattern(1, 0, 0);
        $error = "Invalid string format";

        $stringData = $this->requiredData->validateString($string, $pattern, $error);

        $expectedContent = array(
            "chars" => $string,
            "error" => ""
        );

        $this->assertSame($expectedContent, $stringData);
    }
}
