<?php

namespace Radar\Validators;

enum DataType: string {
    case NAME = 'name';
    case NUM = 'number';
    case URL = 'url';
    case CHARS = 'chars';
    case EMAIL = 'email';
}
