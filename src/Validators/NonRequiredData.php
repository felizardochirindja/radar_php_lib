<?php

namespace Radar\Validators;

use function is_array;
use Radar\Core\DataFilter;
use Radar\Core\DataPattern;
use Radar\Core\Validator;
use Radar\Validatable;

final class NonRequiredData extends Validator implements Validatable
{
    /**
     * valida um nome
     * 
     * @param string $name nome a ser validado
     * @param string $error erro caso o nome seja inválido
    */
    public function validateName(string $name, string $error): array
    {
        $dataType = DataType::NAME;
        $this->validateData($name, $dataType, $error, $this->filterSanitizedName(...));

        $data = [
            $dataType->value => (string) $this->validData,
            "error" => $this->invalidDataError
        ];

        $this->emptyError();
        return $data;
    }

    /**
     * valida um número
     * 
     * @param string $number número a ser validado
     * @param string $error erro caso o número seja inválido
    */
    public function validateNumber(int|string $number, string $error): array
    {
        $dataType = DataType::NUM;
        $this->validateData($number, $dataType, $error, $this->filterSanitizedNumber(...));
        
        $numberData = [
            $dataType->value => empty($this->validData) ? '' : (int) $this->validData,
            "error" => $this->invalidDataError
        ];
        
        $this->emptyError();
        return $numberData;
    }

    /**
     * valida um email
     * 
     * @param string $email email a ser validado
     * @param string $error erro caso o email seja inválido
    */
    public function validateEmail(string $email, string $error): array
    {
        return $this->validateUsingFilters($email, $error, DataType::EMAIL, DataFilter::Email);
    }

    /**
     * valida uma URL
     * 
     * @param string $url url a ser validada
     * @param string $error erro caso a url seja inválida
    */
    public function validateURL(string $url, string $error): array
    {
        return $this->validateUsingFilters($url, $error, DataType::URL, DataFilter::Url);
    }

    private function validateWithoutFilter(string $data, string $error, DataType $dataType): string|int|array
    {
        $arrayWithoutValues = $this->validateEmptyData($data, $dataType);

        if (is_array($arrayWithoutValues)) {
            return $arrayWithoutValues;
        }

        $this->genericError = $error;

        return $this->sanitizeData($data);
    }

    private function validateUsingFilters(string $data, string $error, DataType $dataType, DataFilter $filter): array
    {
        $sanitizedData = $this->validateWithoutFilter($data, $error, $dataType);

        if (is_array($sanitizedData)) {
            return $sanitizedData;
        }

        $this->filterDataByFilters($sanitizedData, $filter);
        
        $data = [
            $dataType->value => (string) $this->validData,
            "error" => $this->invalidDataError
        ];
        
        $this->emptyError();

        return $data;
    }

    /**
     * valida um ou uma cadeia de caracteres de modo que contenha
     * o numero de caracteres desejados, invalidando tags HTML e espaços em branco
     * 
     * @param string $chars caracteres a serem validados
     * @param string $error erro caso os caracteres sejam inválidos
    */
    public function validateString(int|string $chars, DataPattern $pattern, string $error): array
    {
        $dataType = DataType::CHARS;
        $this->validateData($chars, $dataType, $error, $this->filterSanitizedText(...), $pattern);

        $data = [
            $dataType->value => (string) $this->validData,
            "error" => $this->invalidDataError
        ];
        
        $this->emptyError();
        return $data;
    }

    /**
     * retorna um array com string vazia em todos os indices,
     * caso seja entrege um dado vazio
     * 
     * @param int|string $givenData data to be verified if is empty
     * @param DataType $dataType type of data to be validated, that will be used as a index of first item in the array
     * (types normaly used: name, url, email, chars)
    */
    public function validateEmptyData(int|string $givenData, DataType $dataType): array|false
    {
        if (empty($givenData)) {
            $data = [
                $dataType->value => "",
                "error" => ""
            ];

            return $data;
        }
        
        return false;
    }

    public function validateData(string $data, DataType $dataType, string $error, callable $filterFunction, DataPattern $pattern = null)
    {
        $sanitizedData = $this->validateWithoutFilter($data, $error, $dataType);

        if (is_array($sanitizedData)) {
            return $sanitizedData;
        }

        if ($pattern === null) {
            $filterFunction($sanitizedData);
        } else {
            $filterFunction($sanitizedData, $pattern);
        }
    }
}
