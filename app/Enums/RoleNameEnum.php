<?php

namespace App\Enums;

use Webfox\LaravelBackedEnums\BackedEnum;
use Webfox\LaravelBackedEnums\IsBackedEnum;
enum RoleNameEnum: string implements BackedEnum
{
    use IsBackedEnum;

    case ADMIN = 'admin';
    case GUDANG = 'gudang';
    case KITCHEN = 'kitchen';
    case PACKING_PRODUK = 'packing_produk';
    case PACKING_KIRIM = 'packing_kirim';
}
