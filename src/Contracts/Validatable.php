<?php

namespace Radar\Contracts;
 
interface Validatable
{
    function validateName(string $name, string $error): array;
    function validateNumber(int|string $number, string $error): array;
    function validateEmail(string $email, string $error): array;
    function validateURL(string $url, string $error): array;
    function validateString(int|string $chars): array;
}
