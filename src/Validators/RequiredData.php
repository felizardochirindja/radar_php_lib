<?php

namespace Radar\Validators;

use function is_array;
use Radar\Core\Validator;
use Radar\Contracts\Validatable;

require __DIR__. "/../../vendor/autoload.php";

final class RequiredData extends Validator implements Validatable
{
    private string $requiredDataError;

    public function __construct(
        private string $genericDataError
    ) {
        parent::__construct();
    }

    /**
     * @param string $name nome a ser validado
     * @param string $error erro caso o nome seja inválido
    */
    public function validateName(string $name, string $error) : array
    {
        $arrayWithEmptyDataError = $this->validateEmptyData($name, "name");

        if (is_array($arrayWithEmptyDataError)) {
            return $arrayWithEmptyDataError;
        }

        $this->genericError = $error;

        $sanitizedName = $this->sanitizeData($name);
        $this->filterSanitizedName($sanitizedName);

        $nameData = [
            "name"  => (string) $this->validData,
            "error" => $this->invalidDataError
        ];
        
        $this->emptyError();
        $this->removeRequiredDataError();

        return $nameData;
    }
    
    /**
     * @param string $number número a ser validado
     * @param string $error erro caso o número seja inválido
    */
    public function validateNumber(int | string $number, string $error) : array
    {
        $arrayWithEmptyDataError = $this->validateEmptyData($number, "number");

        if (is_array($arrayWithEmptyDataError)) {
            return $arrayWithEmptyDataError;
        }

        $this->genericError = $error;

        $sanitizedNumber = $this->sanitizeData($number);
        $this->filterSanitizedNumber($sanitizedNumber);

        $numberData = [
            "number" => (int) $this->validData,
            "error"  => $this->invalidDataError
        ];
        
        $this->emptyError();
        $this->removeRequiredDataError();

        return $numberData;
    }

    /**
     * @param string $email email a ser validado
     * @param string $error erro caso o email seja inválido
    */
    public function validateEmail(string $email, string $error) : array
    {
        $arrayWithEmptyDataError = $this->validateEmptyData($email, "email");

        if (is_array($arrayWithEmptyDataError)) {
            return $arrayWithEmptyDataError;
        }

        $this->genericError = $error;

        $sanitizedEmail = $this->sanitizeData($email);
        $this->filterEmail($sanitizedEmail);

        $emailData = [
            "email"  => (string) $this->validData,
            "error"  => $this->invalidDataError
        ];
        
        $this->emptyError();
        $this->removeRequiredDataError();

        return $emailData;
    }

    /**
     * @param string $url url a ser validada
     * @param string $error erro caso a url seja inválida
    */
    public function validateURL(string $url, string $error) : array
    {
        $arrayWithEmptyDataError = $this->validateEmptyData($url, "URL");

        if (is_array($arrayWithEmptyDataError)) {
            return $arrayWithEmptyDataError;
        }

        $this->genericError = $error;

        $sanitizedUrl = $this->sanitizeData($url);
        $this->filterUrl($sanitizedUrl);

        $urlData = [
            "url"   => (string) $this->validData,
            "error" => $this->invalidDataError
        ];
        
        $this->emptyError();
        $this->removeRequiredDataError();

        return $urlData;
    }

    /**
     * @param string $chars caracteres a serem validados
     * @param string $error erro caso os caracteres sejam inválidos
    */
    public function validateString(int | string $chars) : array
    {
        $arrayWithEmptyDataError = $this->validateEmptyData($chars, "chars");

        if (is_array($arrayWithEmptyDataError)) {
            return $arrayWithEmptyDataError;
        }

        $sanitizedString = $this->sanitizeData($chars);
        $this->filterSanitizedText($sanitizedString);

        $data = [
            "chars" => (string) $this->validData,
            "error" => $this->invalidDataError
        ];
        
        $this->emptyError();
        $this->removeRequiredDataError();

        return $data;
    }

    protected function validateEmptyData(
        int | string $givenData, 
        string $dataType) : array | false
    {
        if (empty($givenData)) {
            $this->setRequiredDataError();

            $data = [
                $dataType => "",
                "error"   => $this->requiredDataError
            ];

            return $data;
        }
        
        return false;
    }

    private function setRequiredDataError() : void
    {
        $this->requiredDataError = empty($this->requiredDataError) ? 
                                   $this->genericDataError : 
                                   $this->requiredDataError;
    }

    private function removeRequiredDataError(): void
    {
        $this->requiredDataError = "";
    }

    /**
     * @param string $error erro caso o seja um dado vazio
    */
    public function setError(string $error) : void
    {
        $this->requiredDataError = $error;
    }
}
