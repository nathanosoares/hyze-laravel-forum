<?php

namespace App\Extensions\Pages;

use Illuminate\Http\Request;

abstract class PageController
{

    abstract public function getData(Request $request): array;
}
