<?php

namespace Radar\Core;

use function preg_match;
use function is_numeric;
use function filter_var;
use function trim;
use function stripslashes;
use function htmlspecialchars;
use Radar\Core\DataLimiter;

require __DIR__ . "/../../vendor/autoload.php";

abstract class Validator
{
    protected int | string $validData;
    private bool $allowNegativeNumber;
    
    private DataLimiter $dataLimiter;

    protected string $invalidDataError;
    private   string $negativeNumberError;
    protected string $genericError;

    public function __construct() {
        $this->emptyValidData();
        $this->emptyError();
        $this->allowNegativeNumber = true;
        $this->dataLimiter = new DataLimiter();
    }

    abstract protected function validateEmptyData(
        int | string $givenData, 
        string $dataType
    ): array| bool;

    protected function filterSanitizedName(string $name) : void
    {
        $isNameProperlyLimited = $this->dataLimiter->isProperlyLimited($name);

        if (!$isNameProperlyLimited) {
            $this->invalidDataError = $this->dataLimiter->error;
            return;
        }
            
        $this->filterName($name);
        $this->dataLimiter->setDefaultConfiguration();
    }

    private function filterName(string $name) : void
    {
        if (!preg_match("/^[a-zA-Z áàãéèíìóòõúùç]*$/", $name)) {
            $this->invalidDataError = $this->genericError;
            return;
        } 
        
        $this->validData = $name;
    }
    
    protected function filterSanitizedNumber(int | string $number) : void
    {
        $isNumberProperlyLimited = $this->dataLimiter->isProperlyLimited($number);

        if (!$isNumberProperlyLimited) {
            $this->invalidDataError = $this->dataLimiter->error;
            return;
        }
        
        $this->filterNumber($number);
        $this->dataLimiter->setDefaultConfiguration();
    }
    
    private function filterNumber(int | string $number) : void
    {
        if (!is_numeric($number)) {
            $this->invalidDataError = $this->genericError;
            $this->allowNegativeNumber = true;
            
            return;
        }  
         
        if ( !($this->allowNegativeNumber || !$this->isNumberNegative($number)) ) {
            $this->invalidDataError = $this->negativeNumberError;
            return;
        }

        $this->validData = $number;
        $this->allowNegativeNumber = true;
    }
    
    public function denyNegativeNumber(string $error) : void
    {   
        $this->allowNegativeNumber = false;
        $this->negativeNumberError = $error;
    }

    private function isNumberNegative(int $number) : bool
    {
        if ($number < 0) {
            return true;
        }
        
        return false;
    }
    
    protected function filterSanitizedText(string | int $text) : void
    {
        $isTextProperlyLimited = $this->dataLimiter->isProperlyLimited($text);

        if (!$isTextProperlyLimited) {
            $this->invalidDataError = $this->dataLimiter->error;
            return;
        }

        $this->validData = $text;
        $this->dataLimiter->setDefaultConfiguration();
    }

    protected function filterDataByFilters(string $data, $filter) : void
    {
        if (!filter_var($data, $filter)) {
            $this->invalidDataError = $this->genericError;
            return;
        }
        
        $this->validData = $data;
    }

    // Elimita espaços em branco, baras invertidas e converte tags html em apenas strings
    protected function sanitizeData(int | string $data) : int | string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        
        return $data;
    }

    public function setDelimitation(int $minChars, int $maxChars, string $error) : void
    {
        $this->dataLimiter->setDelimitation($minChars, $maxChars, $error);
    }

    public function setLength(int $lenght, string $error) : void
    {
        $this->dataLimiter->setLength($lenght, $error);
    }

    private function emptyValidData() : void
    {
        $this->validData = "";
    }

    protected function emptyError() : void
    {
        $this->invalidDataError = "";
    }
}
