<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $items =['사과','바나나','우유'];

        return view('welcome', [
            'items'=>$items,
        ]);
    }
}
