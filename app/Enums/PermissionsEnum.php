<?php

namespace App\Enums;

use Webfox\LaravelBackedEnums\BackedEnum;
use Webfox\LaravelBackedEnums\IsBackedEnum;

enum PermissionsEnum: string implements BackedEnum
{
    use IsBackedEnum;

    /**
     * Add your Enums below using.
     * e.g. case Standard = 'standard';
     */
    case BAHAN_VIEW_ALL = 'bahan.viewAll';
    case BAHAN_VIEW = 'bahan.view';
    case BAHAN_CREATE = 'bahan.create';
    case BAHAN_UPDATE = 'bahan.update';
    case BAHAN_DELETE = 'bahan.delete';
    case BAHAN_RESTORE = 'bahan.restore';
    case BAHAN_FORCE_DELETE = 'bahan.forceDelete';

    case PRODUK_VIEW_ALL = 'produk.viewAll';
    case PRODUK_VIEW = 'produk.view';
    case PRODUK_CREATE = 'produk.create';
    case PRODUK_UPDATE = 'produk.update';
    case PRODUK_DELETE = 'produk.delete';
    case PRODUK_RESTORE = 'produk.restore';
    case PRODUK_FORCE_DELETE = 'produk.forceDelete';

    case PRODUKSI_VIEW_ALL = 'produksi.viewAll';
    case PRODUKSI_VIEW = 'produksi.view';
    case PRODUKSI_CREATE = 'produksi.create';
    case PRODUKSI_UPDATE = 'produksi.update';
    case PRODUKSI_DELETE = 'produksi.delete';
    case PRODUKSI_RESTORE = 'produksi.restore';
    case PRODUKSI_FORCE_DELETE = 'produksi.forceDelete';

    case RESEP_VIEW_ALL = 'resep.viewAll';
    case RESEP_VIEW = 'resep.view';
    case RESEP_CREATE = 'resep.create';
    case RESEP_UPDATE = 'resep.update';
    case RESEP_DELETE = 'resep.delete';
    case RESEP_RESTORE = 'resep.restore';
    case RESEP_FORCE_DELETE = 'resep.forceDelete';

    case RESEP_BAHAN_VIEW_ALL = 'resep_bahan.viewAll';
    case RESEP_BAHAN_VIEW = 'resep_bahan.view';
    case RESEP_BAHAN_CREATE = 'resep_bahan.create';
    case RESEP_BAHAN_UPDATE = 'resep_bahan.update';
    case RESEP_BAHAN_DELETE = 'resep_bahan.delete';
    case RESEP_BAHAN_RESTORE = 'resep_bahan.restore';
    case RESEP_BAHAN_FORCE_DELETE = 'resep_bahan.forceDelete';

    case SATUAN_VIEW_ALL = 'satuan.viewAll';
    case SATUAN_VIEW = 'satuan.view';
    case SATUAN_CREATE = 'satuan.create';
    case SATUAN_UPDATE = 'satuan.update';
    case SATUAN_DELETE = 'satuan.delete';
    case SATUAN_RESTORE = 'satuan.restore';
    case SATUAN_FORCE_DELETE = 'satuan.forceDelete';

    case SISA_PRODUKSI_VIEW_ALL = 'sisa_produksi.viewAll';
    case SISA_PRODUKSI_VIEW = 'sisa_produksi.view';
    case SISA_PRODUKSI_CREATE = 'sisa_produksi.create';
    case SISA_PRODUKSI_UPDATE = 'sisa_produksi.update';
    case SISA_PRODUKSI_DELETE = 'sisa_produksi.delete';
    case SISA_PRODUKSI_RESTORE = 'sisa_produksi.restore';
    case SISA_PRODUKSI_FORCE_DELETE = 'sisa_produksi.forceDelete';

    case STOK_GUDANG_VIEW_ALL = 'stok_gudang.viewAll';
    case STOK_GUDANG_VIEW = 'stok_gudang.view';
    case STOK_GUDANG_CREATE = 'stok_gudang.create';
    case STOK_GUDANG_UPDATE = 'stok_gudang.update';
    case STOK_GUDANG_DELETE = 'stok_gudang.delete';

    case STOK_KITCHEN_VIEW_ALL = 'stok_kitchen.viewAll';
    case STOK_KITCHEN_VIEW = 'stok_kitchen.view';
    case STOK_KITCHEN_CREATE = 'stok_kitchen.create';
    case STOK_KITCHEN_UPDATE = 'stok_kitchen.update';
    case STOK_KITCHEN_DELETE = 'stok_kitchen.delete';

    case STOK_PRODUK_VIEW_ALL = 'stok_produk.viewAll';
    case STOK_PRODUK_VIEW = 'stok_produk.view';
    case STOK_PRODUK_CREATE = 'stok_produk.create';
    case STOK_PRODUK_UPDATE = 'stok_produk.update';
    case STOK_PRODUK_DELETE = 'stok_produk.delete';

    case USER_ROLE_VIEW_ALL = 'user_role.viewAll';
    case USER_ROLE_VIEW = 'user_role.view';
    case USER_ROLE_CREATE = 'user_role.create';
    case USER_ROLE_UPDATE = 'user_role.update';
    case USER_ROLE_DELETE = 'user_role.delete';

    case USER_VIEW_ALL = 'user.viewAll';
    case USER_VIEW = 'user.view';
    case USER_CREATE = 'user.create';
    case USER_UPDATE = 'user.update';
    case USER_DELETE = 'user.delete';
}

function getPermissionsByPrefix(string $prefix): array
{
    return array_filter(PermissionsEnum::cases(), function ($permission) use ($prefix) {
        return strpos($permission->value, $prefix) === 0;
    });
}
