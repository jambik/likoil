<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Product;
use Illuminate\Http\Request;

class SearchController extends FrontendController
{
    /**
     * Search page.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->get('search');

        $products = Product::search($query)->get();

        return view('search', compact('products'));
    }
}
