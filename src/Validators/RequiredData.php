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
     * valida um nome
     * 
     * @param string $name nome a ser validado
     * @param string $error erro caso o nome seja inválido
     * 
     * @return array
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
     * valida um número
     * 
     * @param string $number número a ser validado
     * @param string $error erro caso o número seja inválido
     * 
     * @return array
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
     * valida um email
     * 
     * @param string $email email a ser validado
     * @param string $error erro caso o email seja inválido
     * 
     * @param array
    */
    public function validateEmail(string $email, string $error) : array
    {
        $arrayWithEmptyDataError = $this->validateEmptyData($email, "email");

        if (is_array($arrayWithEmptyDataError)) {
            return $arrayWithEmptyDataError;
        }

        $this->genericError = $error;

        $sanitizedEmail = $this->sanitizeData($email);
        $this->filterDataByFilters($sanitizedEmail, FILTER_VALIDATE_EMAIL);

        $emailData = [
            "email"  => (string) $this->validData,
            "error"  => $this->invalidDataError
        ];
        
        $this->emptyError();
        $this->removeRequiredDataError();

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
        $arrayWithEmptyDataError = $this->validateEmptyData($url, "URL");

        if (is_array($arrayWithEmptyDataError)) {
            return $arrayWithEmptyDataError;
        }

        $this->genericError = $error;

        $sanitizedUrl = $this->sanitizeData($url);
        $this->filterDataByFilters($sanitizedUrl, FILTER_VALIDATE_URL);

        $urlData = [
            "url"   => (string) $this->validData,
            "error" => $this->invalidDataError
        ];
        
        $this->emptyError();
        $this->removeRequiredDataError();

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

    /**
     * returna um array com string vazia em todos os indices,
     * caso seja entrege um dado vazio
     * 
     * @param int|string $givenData data to be verified if is empty, caso esteja vazio é retornado um array a mensagem de erro no índice "error"
     * @param string $dataType type of data to be validated, that will be used as a index of first item in the array (types normaly used: name, url, email, password)
     * 
     * @return array|false
    */
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

    /**
     * se o erro génerico estiver vazio, é usado o erro definido pela função setError
     * caso o erro genério não esteja vazio será usado ele mesmo como erro quando
     * se o um dado estiver vazio
    */
    private function setRequiredDataError() : void
    {
        $this->requiredDataError = empty($this->requiredDataError) ? 
                                   $this->genericDataError : 
                                   $this->requiredDataError;
    }

    /**
     * limpa a mensagem de erro depois de cada validação
    */
    private function removeRequiredDataError(): void
    {
        $this->requiredDataError = "";
    }

    /**
     * insere a mensagem de erro retornada caso o dado o dado seja vazios
     * 
     * @param string $error erro caso o seja um dado vazio
    */
    public function setError(string $error) : void
    {
        $this->requiredDataError = $error;
    }
}
