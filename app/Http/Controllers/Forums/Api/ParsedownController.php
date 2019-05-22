<?php


namespace App\Http\Controllers\Forums\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParsedownController extends Controller
{

    public function converter(Request $request)
    {
        if (!$request->get('markdown')) {
            return "";
        }

        return markconverter($request->markdown);
    }

}