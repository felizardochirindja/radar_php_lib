<?php

namespace Radar\Validators;

use function is_array;
use Radar\Core\Validator;
use Radar\Contracts\Validatable;

require __DIR__ . "/../../vendor/autoload.php";

final class NonRequiredData extends Validator implements Validatable
{
    /**
     * valida um nome
     * 
     * @param string $name nome a ser validado
     * @param string $error erro caso o nome seja inválido
     * 
     * @return array
    */
    public function validateName(string $name, string $error) : array
    {
        $arrayWithoutValues = $this->validateEmptyData($name, "name");

        if (is_array($arrayWithoutValues)) {
            return $arrayWithoutValues;
        }

        $this->genericError = $error;

        $sanitizedName = $this->sanitizeData($name);
        $this->filterSanitizedName($sanitizedName);

        $nameData = [
            "name"  => (string) $this->validData,
            "error" => $this->invalidDataError
        ];

        $this->emptyError();

        return $nameData;
    }
    
    /**
     * valida um número
     * 
     * @param string $number número a ser validado
     * @param string $error erro caso o número seja inválido
     * 
     * @return array
    */
    public function validateNumber(int | string $number, string $error) : array
    {
        $arrayWithoutValues = $this->validateEmptyData($number, "number");

        if (is_array($arrayWithoutValues)) {
            return $arrayWithoutValues;
        }

        $this->genericError = $error;

        $sanitizedNumber = $this->sanitizeData($number);
        $this->filterSanitizedNumber($sanitizedNumber);
        
        $numberData = [
            "number" => (int) $this->validData,
            "error"  => $this->invalidDataError
        ];
        
        $this->emptyError();

        return $numberData;
    }

    /**
     * valida um email
     * 
     * @param string $email email a ser validado
     * @param string $error erro caso o email seja inválido
     * 
     * @param array
    */
    public function validateEmail(string $email, string $error) : array
    {
        $arrayWithoutValues = $this->validateEmptyData($email, "email");

        if (is_array($arrayWithoutValues)) {
            return $arrayWithoutValues;
        }

        $this->genericError = $error;

        $sanitizedEmail = $this->sanitizeData($email);
        $this->filterEmail($sanitizedEmail);
        
        $emailData = [
            "email" => (string) $this->validData,
            "error" => $this->invalidDataError
        ];
        
        $this->emptyError();

        return $emailData;
    }

    /**
     * valida uma URL
     * 
     * @param string $url url a ser validada
     * @param string $error erro caso a url seja inválida
     * 
     * @return array
    */
    public function validateURL(string $url, string $error) : array
    {
        $arrayWithoutValues = $this->validateEmptyData($url, "url");

        if (is_array($arrayWithoutValues)) {
            return $arrayWithoutValues;
        }

        $this->genericError = $error;

        $sanitizedUrl = $this->sanitizeData($url);
        $this->filterUrl($sanitizedUrl);
        
        $urlData = [
            "url"   => (string) $this->validData,
            "error" => $this->invalidDataError
        ];

        $this->emptyError();

        return $urlData;
    }

    /**
     * valida um ou uma cadeia de caracteres de modo que contenha
     * o numero de caracteres desejados, invalidando tags HTML e espaços em branco
     * 
     * @param string $chars caracteres a serem validados
     * @param string $error erro caso os caracteres sejam inválidos
     * 
     * @return array
    */
    public function validateString(int | string $chars) : array
    {
        $emptyValidatedData = $this->validateEmptyData($chars, "chars");

        if (is_array($emptyValidatedData)) {
            return $emptyValidatedData;
        }

        $sanitizedString = $this->sanitizeData($chars);
        $this->filterSanitizedText($sanitizedString);

        $data = [
            "chars" => (string) $this->validData,
            "error" => $this->invalidDataError
        ];
        
        $this->emptyError();

        return $data;
    }

    /**
     * returna um array com string vazia em todos os indices,
     * caso seja entrege um dado vazio
     * 
     * @param int|string $givenData data to be verified if is empty
     * @param string $dataType type of data to be validated, that will be used as a index of first item in the array (types normaly used: name, url, email, password)
     * 
     * @return array|false
    */
    protected function validateEmptyData(
        int | string $givenData,
        string $dataType
    ) : array | false
    {
        if (empty($givenData)) {
            $data = [
                $dataType => "",
                "error"   => ""
            ];

            return $data;
        }
        
        return false;
    }
}
