<?php

namespace Radar\Core;

use function preg_match;
use function is_numeric;
use function filter_var;
use function trim;
use function stripslashes;
use function htmlspecialchars;

use Exception;
use InvalidArgumentException;
use Radar\Core\DataLimiter;

abstract class Validator
{
    protected int|string $validData;
    private bool $allowNegativeNumber;
    
    protected string $invalidDataError;
    private string $negativeNumberError;
    protected string $genericError;

    public function __construct(private DataLimiter $dataLimiter)
    {
        $this->emptyValidData();
        $this->emptyError();
        $this->allowNegativeNumber = true;
    }

    abstract protected function validateEmptyData(int|string $givenData, string $dataType): array|bool;

    protected function filterSanitizedName(string $name): void
    {
        if (!$this->isDataDelimitationValid($name)) {
            return;
        }
            
        $this->filterName($name);
        $this->dataLimiter->setDefaultConfiguration();
    }

    private function filterName(string $name): void
    {
        if (!preg_match("/^[a-zA-Z áàãéèíìóòõúùç]*$/", $name)) {
            $this->invalidDataError = $this->genericError;
            return;
        } 
        
        $this->validData = $name;
    }
    
    protected function filterSanitizedNumber(int|string $number): void
    {
        if (!$this->isDataDelimitationValid($number)) {
            return;
        }
        
        $this->filterNumber($number);
        $this->dataLimiter->setDefaultConfiguration();
    }
    
    private function filterNumber(int|string $number): void
    {
        if (!is_numeric($number)) {
            $this->invalidDataError = $this->genericError;
            $this->allowNegativeNumber = true;
            return;
        }  
         
        if (!($this->allowNegativeNumber || !$this->isNumberNegative($number))) {
            $this->invalidDataError = $this->negativeNumberError;
            return;
        }

        $this->validData = $number;
        $this->allowNegativeNumber = true;
    }
    
    /** esta funcao deve ser chamada antes de validar um numero. ela garente que o numero nao seja negativo */
    public function denyNegativeNumber(string $error): void
    {
        $this->allowNegativeNumber = false;
        $this->negativeNumberError = $error;
    }

    private function isNumberNegative(int $number): bool
    {
        return ($number < 0);
    }
    
    protected function filterSanitizedText(string|int $text, DataPattern $pattern): void
    {
        if ($pattern->getDataQuantity() > $this->dataLimiter->getCharsNumber()) {
            throw new Exception('pattern data quantity must not be greater to string delimitation');
        }

        if (!$this->isDataDelimitationValid($text)) {
            return;
        }

        $this->validData = $text;
        $this->dataLimiter->setDefaultConfiguration();
    }

    /** 
     * filtra o dado usando os filtros nativos do php
     * 
     * @throws InvalidArgumentException if the filter is invalid
    */
    protected function filterDataByFilters(string $data, DataFilter $filter): void
    {
        if (!filter_var($data, $filter->value)) {
            $this->invalidDataError = $this->genericError;
            return;
        }
        
        $this->validData = $data;
    }

    /** Elimita espaços em branco, baras invertidas e converte tags html */
    protected function sanitizeData(int|string $data): int|string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    /** verifica se o dado respeita a delimitacao(número de caracteres) definida */
    private function isDataDelimitationValid(string $data): bool
    {
        $isDataProperlyLimited = $this->dataLimiter->isProperlyLimited($data);

        if (!$isDataProperlyLimited) {
            $this->invalidDataError = $this->dataLimiter->error;
            return false;
        }

        return true;
    }

    /**
     * Define o mínimo e máximo de caracteres ou dígidos
     * 
     * @param int $minChars numero mínimo de caracteres ou dígitos
     * @param int $maxChars número máximo de caracteres ou dígitos
     * @param string $error mensagem de erro caso o dado não obedeça a delimitacao
    */
    public function setDelimitation(int $minChars, int $maxChars, string $error): void
    {
        $this->dataLimiter->setDelimitation($minChars, $maxChars, $error);
    }

    public function setLength(int $lenght, string $error): void
    {
        $this->dataLimiter->setLength($lenght, $error);
    }

    private function emptyValidData(): void
    {
        $this->validData = "";
    }

    protected function emptyError(): void
    {
        $this->invalidDataError = "";
    }
}
