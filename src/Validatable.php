<?php

namespace Radar;

use Radar\Core\DataPattern;

interface Validatable
{
    public function validateName(string $name, string $error): array;
    public function validateNumber(int|string $number, string $error): array;
    public function validateEmail(string $email, string $error): array;
    public function validateURL(string $url, string $error): array;
    public function validateString(int|string $chars, DataPattern $dataPattern, string $error): array;
}
