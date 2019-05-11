<?php


namespace App\Http\Controllers\Chatter\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParsedownController extends Controller
{

    public function converter(Request $request)
    {
        $request->validate([
            'markdown' => 'required'
        ]);

        return markconverter($request->markdown);
    }

}