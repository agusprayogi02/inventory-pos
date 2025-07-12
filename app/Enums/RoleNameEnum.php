<?php

namespace App\Enums;

enum RoleNameEnum: string
{
    case ADMIN = 'admin';
    case GUDANG = 'gudang';
    case KITCHEN = 'kitchen';
    case PACKING_PRODUK = 'packing_produk';
    case PACKING_KIRIM = 'packing_kirim';
}
