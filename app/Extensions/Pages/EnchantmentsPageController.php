<?php

namespace App\Extensions\Pages;

use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;

class EnchantmentsPageController extends PageController
{
    public function getData(Request $request): array
    {
        return [
            'enchantments' => json_decode(json_encode((config('enchantments'))), false)
        ];
    }
}
