<?php

namespace Radar\Core;

enum DataFilter: int
{
    case Email = FILTER_VALIDATE_EMAIL;
    case Url = FILTER_VALIDATE_URL;
}
