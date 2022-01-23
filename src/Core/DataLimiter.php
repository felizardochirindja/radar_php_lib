<?php

namespace Radar\Core;

use function strlen;

final class DataLimiter
{
    private bool $useDelimitation;

    private int $charsNumber;
    private int $minChars;
    private int $maxChars;
    
    public string $error;

    public function __construct()
    {
        $this->setDefaultConfiguration();
    }

    /**
     * insere valores padrão nos atributos
    */
    public function setDefaultConfiguration() : void
    {
        $this->minChars        = 1;
        $this->maxChars        = 50;
        $this->useDelimitation = true;
    }

    public function isProperlyLimited(string $data) : bool
    {
        if ($this->useDelimitation && 
            $this->hasMinMaxChars($data)) {
                return true;
        }
        
        if (!$this->hasMinMaxChars($data)) {
            return false;
        }

        return strlen($data) == $this->charsNumber;
    }

    private function hasMinMaxChars(string $data) : bool
    {
        return $this->hasMinChars($data) &&
               !$this->hasMoreThanMaxChars($data);
    }
    
    private function hasMinChars(string $data) : bool
    {
        return strlen($data) >= $this->minChars;
    }

    private function hasMoreThanMaxChars(string $data) : bool
    {
        return strlen($data) > $this->maxChars;
    }

    /**
     * @param int $minChars número mínimo de caracteres
     * @param int $maxChars número máximo de caracteres
     * @param string $error erro caso o tamanho dos caracteres esteja fora do intervalo
     * 
     * @throws InvalidArgumentException
    */
    public function setDelimitation(int $minChars, int $maxChars, string $error) : void
    {
        if (($minChars <= 0) || ($maxChars <= 0)) {
            throw new \InvalidArgumentException("minChars or maxChars must not be less than 1!");
        }

        if ($minChars > $maxChars) {
            throw new \InvalidArgumentException("minChars must be less than maxChars!");
        }

        if ($minChars == $maxChars) {
            throw new \InvalidArgumentException("minChars must not be iqual to maxChars!");
        }

        $this->minChars = $minChars;
        $this->maxChars = $maxChars;
        $this->error    = $error;
    }

    /**
     * @param int $lenght   único número de caracteres aceite
     * @param string $error erro retornado caso o número de caracteres não seja o desejado
     * 
     * @throws InvalidArgumentException
    */
    public function setLength(int $lenght, string $error) : void
    {
        if ($lenght <= 0) {
            throw new \InvalidArgumentException("Lenght must not be less than 1!");
        }

        $this->useDelimitation = false;
        $this->charsNumber     = $lenght;
        $this->error           = $error;
    }
}
