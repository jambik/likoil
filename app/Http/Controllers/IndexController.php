<?php

namespace App\Http\Controllers;

use App\Page;

class IndexController extends FrontendController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::find(1);

        return view('index', compact('page'));
    }
}
