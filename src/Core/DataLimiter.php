<?php

namespace Radar\Core;

use function strlen;

/**
 * esta classe faz validacoes que tem haver com o numero de caracteres ou digitos
 */
final class DataLimiter
{
    private bool $useDelimitation;

    private int $charsNumber;
    private int $minChars;
    private int $maxChars;

    private const DEFAULT_MIN_CHARS = 1;
    private const DEFAULT_MAX_CHARS = 50;

    public string $error;

    public function __construct()
    {
        $this->setDefaultConfiguration();
    }

    /**
     * insert the default values to the minumun characters, maximus characters and useDelimitation atributes,
     * mininum charactes : 1, maximus characteres : 50, useDelimitation : true
     */
    public function setDefaultConfiguration(): void
    {
        $this->minChars = self::DEFAULT_MIN_CHARS;
        $this->maxChars = $this->charsNumber = self::DEFAULT_MAX_CHARS;
        $this->useDelimitation = true;
    }

    /**
     * verify if the given data has the correct number of characters
     * 
     * @param string $data the string to verify the number os characters
     */
    public function isProperlyLimited(string $data): bool
    {
        if (
            $this->useDelimitation &&
            $this->hasMinMaxChars($data)
        ) {
            return true;
        }

        if (!$this->hasMinMaxChars($data)) {
            return false;
        }

        return strlen($data) == $this->charsNumber;
    }

    /**
     * verifica se a string tem pelo menos os caracteres minimos
     * e não excede os caracteres máximos desejados
     * 
     * @param string $data string to be verified
     */
    private function hasMinMaxChars(string $data): bool
    {
        return $this->hasMinChars($data) &&
            !$this->hasMoreThanMaxChars($data);
    }

    /**
     * verify if the given string has the mininum characters wanted
     * 
     * @param string $data the string to be verified
     */
    private function hasMinChars(string $data): bool
    {
        return strlen($data) >= $this->minChars;
    }

    /**
     * verify if the given string has the more than maximum characters wanted
     * 
     * @param string $data the string to be verified
     */
    private function hasMoreThanMaxChars(string $data): bool
    {
        return strlen($data) > $this->maxChars;
    }

    /**
     * define de mininum and maximum characters acepted
     * 
     * @param int $minChars número mínimo de caracteres
     * @param int $maxChars número máximo de caracteres
     * @param string $error erro caso o tamanho dos caracteres esteja fora do intervalo
     * 
     * @throws InvalidArgumentException
     */
    public function setDelimitation(int $minChars, int $maxChars, string $error): void
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
        $this->charsNumber = $maxChars;
        $this->error = $error;
    }

    /**
     * define the unique length of caracters acepted on a given data
     * 
     * @param int $lenght único número de caracteres aceite
     * @param string $error erro retornado caso o número de caracteres não seja o desejado
     * 
     * @throws InvalidArgumentException
     */
    public function setLength(int $lenght, string $error): void
    {
        if ($lenght <= 0) {
            throw new \InvalidArgumentException("Lenght must not be less than 1!");
        }

        $this->useDelimitation = false;
        $this->charsNumber = $lenght;
        $this->error = $error;
    }

    public function getCharsNumber(): int
    {
        return $this->charsNumber;
    }
}
