<?php

namespace Workbench\App\Http\Controllers;

use Illuminate\Http\Request;

class Controller
{
    public function __invoke(Request $request)
    {
        return view('app');
        return inertia()->render('Home');
    }

}
