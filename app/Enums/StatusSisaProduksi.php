<?php

namespace App\Enums;

use Webfox\LaravelBackedEnums\IsBackedEnum;
use Webfox\LaravelBackedEnums\BackedEnum;

enum StatusSisaProduksi: string implements BackedEnum
{
    use IsBackedEnum;
    case BAIK = 'baik';
    case RUSAK = 'rusak';
    case KEDALUARSA = 'kedaluarsa';
    case KECIL = 'kecil';
    case BESAR = 'besar';
}
