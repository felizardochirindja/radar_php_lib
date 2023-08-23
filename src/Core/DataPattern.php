<?php

namespace Radar\Core;

use InvalidArgumentException;

class DataPattern
{
    private string $pattern;
    private int $dataQuantity;

    public function __construct(int $totalOfSpecialChars, int $totalOfCapitalLetters, int $totalOfNumbers)
    {
        if ($totalOfCapitalLetters < 0 || $totalOfSpecialChars < 0 || $totalOfNumbers < 0) {
            throw new InvalidArgumentException('arguments must be positive');
        }

        $this->dataQuantity = $totalOfSpecialChars + $totalOfCapitalLetters + $totalOfNumbers;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getDataQuantity(): int
    {
        return $this->dataQuantity;
    }
}
