<?php

namespace App\Http\Controllers\Admin;

use App\Card;
use App\Http\Controllers\BackendController;
use Flash;
use Illuminate\Http\Request;

class DeleteController extends BackendController
{
    protected $validator;

    public function index()
    {
        return view('admin.delete.index');
    }

    public function post(Request $request)
    {
        $cards = $request->get('cards');

        $cards = collect(explode(',', $cards));

        $cards = $cards->map(function ($item) {
            return trim($item);
        });

        $cards = $cards->reject(function ($item) {
            return empty($item);
        });

        $cardsItems = Card::whereIn('code', $cards)->get();

        $cardsDeleted = [];
        foreach ($cardsItems as $item) {
            $cardsDeleted[$item->code] = $item->delete();
        }

        // Show success result
        if ($cardsDeleted) {
            Flash::success('Карты с номерами ('.implode(', ', array_keys($cardsDeleted)).') удалены.');
        }

        return redirect()->back();
    }

}