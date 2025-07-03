<?php

namespace App\Enums;

enum StatusSisaProduksi: string
{
    case BAIK = 'baik';
    case RUSAK = 'rusak';
    case KEDALUARSA = 'kedaluarsa';
    case KECIL = 'kecil';
    case BESAR = 'besar';
}
