<?php

namespace App\Enums;

use Webfox\LaravelBackedEnums\IsBackedEnum;
use Webfox\LaravelBackedEnums\BackedEnum;

enum StokStatus: string implements BackedEnum
{
    use IsBackedEnum;

    case PLUS = '+';
    case MINUS = '-';
}
