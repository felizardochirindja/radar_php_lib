<?php

namespace Radar;
 
interface Validatable
{
    public function validateName(string $name, string $error): array;
    public function validateNumber(int|string $number, string $error): array;
    public function validateEmail(string $email, string $error): array;
    public function validateURL(string $url, string $error): array;
    public function validateString(int|string $chars): array;
}
