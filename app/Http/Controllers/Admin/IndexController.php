<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Http\Requests;

class IndexController extends BackendController
{
    public function index()
    {
//        include base_path('library/epochtasms/index.php');
        return view('admin.index');
    }
}