<?php

namespace Radar\Validators;

use function is_array;
use Radar\Core\DataFilter;
use Radar\Core\DataFiltersMap;
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
        $dataType = 'name';
        $sanitizedName = $this->validateWithoutFilter($name, $error, $dataType);

        if (is_array($sanitizedName)) {
            return $sanitizedName;
        }

        $this->filterSanitizedName($sanitizedName);

        $nameData = [
            $dataType => (string) $this->validData,
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
    */
    public function validateNumber(int|string $number, string $error): array
    {
        $dataType = 'number';
        $sanitizedNumber = $this->validateWithoutFilter($number, $error, $dataType);

        if (is_array($sanitizedNumber)) {
            return $sanitizedNumber;
        }
        
        $this->filterSanitizedNumber($sanitizedNumber);
        
        $numberData = [
            $dataType => empty($this->validData) ? '' : (int) $this->validData,
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
        return $this->validateUsingFilters($email, $error, 'email', DataFilter::Email);
    }

    /**
     * valida uma URL
     * 
     * @param string $url url a ser validada
     * @param string $error erro caso a url seja inválida
    */
    public function validateURL(string $url, string $error): array
    {
        return $this->validateUsingFilters($url, $error, 'url', DataFilter::Url);
    }

    private function validateWithoutFilter(string $data, string $error, string $dataType): string|int|array
    {
        $arrayWithoutValues = $this->validateEmptyData($data, $dataType);

        if (is_array($arrayWithoutValues)) {
            return $arrayWithoutValues;
        }

        $this->genericError = $error;

        return $this->sanitizeData($data);
    }

    private function validateUsingFilters(string $data, string $error, string $dataType, int $filter): array
    {
        $sanitizedData = $this->validateWithoutFilter($data, $error, $dataType);

        if (is_array($sanitizedData)) {
            return $sanitizedData;
        }

        $this->filterDataByFilters($sanitizedData, DataFiltersMap::Map[$filter]);
        
        $data = [
            $dataType => (string) $this->validData,
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
    public function validateString(int|string $chars): array
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
     * retorna um array com string vazia em todos os indices,
     * caso seja entrege um dado vazio
     * 
     * @param int|string $givenData data to be verified if is empty
     * @param string $dataType type of data to be validated, that will be used as a index of first item in the array
     * (types normaly used: name, url, email, chars)
    */
    public function validateEmptyData(int|string $givenData, string $dataType): array|false
    {
        if (empty($givenData)) {
            $data = [
                $dataType => "",
                "error" => ""
            ];

            return $data;
        }
        
        return false;
    }
}
