<?php

namespace App\Http\Controllers\Api;

use App\Card;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function maxId()
    {
        $maxDiscountId = DB::table('discounts')->max('DiscountID');
        $maxDiscountCardId = DB::table('cards')->max('DiscountCardID');

        return response()->json([
            'MaxDiscountId' => $maxDiscountId,
            'MaxDiscountCardId' => $maxDiscountCardId,
        ]);
    }

    public function cardsSave(Request $request)
    {
        $this->validate($request, [
            'data' => 'required'
        ]);

        $data = $request->get('data');

        $data = get_magic_quotes_gpc() ? stripcslashes($data) : $data;

        $jsonObj = json_decode($data);

        if(count($jsonObj->DocumentElement->dcDiscountCard) == 1)
        {
            Card::create([
                'DiscountCardID' => $jsonObj->DocumentElement->dcDiscountCard->DiscountCardID,
                'Code' => $jsonObj->DocumentElement->dcDiscountCard->Code,
            ])->save();
        }
        else
        {
            foreach($jsonObj->DocumentElement->dcDiscountCard as $value)
            {
                Card::create([
                    'DiscountCardID' => $value->DiscountCardID,
                    'Code' => $value->Code,
                ])->save();
            }
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'Карты успешно сохранены',
        ]);
    }

    public function cardsDiscounts(Request $request)
    {
        $this->validate($request, [
            'data' => 'required'
        ]);

        $data = $request->get('data');

        $jsonObj = json_decode($data);

        if(count($jsonObj->DocumentElement->dcDiscountCard) == 1)
        {
            Card::create([
                'DiscountID' => $jsonObj->DocumentElement->rgDiscount->DiscountCardID,
                'Date' => $jsonObj->DocumentElement->rgDiscount->Date,
                'DiscountCardID' => $jsonObj->DocumentElement->rgDiscount->DiscountCardID,
                'Amount' => $jsonObj->DocumentElement->rgDiscount->Amount,
                'Volume' => $jsonObj->DocumentElement->rgDiscount->Volume,
                'Price' => $jsonObj->DocumentElement->rgDiscount->Price,
                'FuelName' => $jsonObj->DocumentElement->rgDiscount->FuelName,
                'AZSCode' => $jsonObj->DocumentElement->rgDiscount->AZSCode,
            ])->save();
        }
        else
        {
            foreach($jsonObj->DocumentElement->dcDiscountCard as $value)
            {
                Card::create([
                    'DiscountID' => $value->DiscountCardID,
                    'Date' => $value->Date,
                    'DiscountCardID' => $value->DiscountCardID,
                    'Amount' => $value->Amount,
                    'Volume' => $value->Volume,
                    'Price' => $value->Price,
                    'FuelName' => $value->FuelName,
                    'AZSCode' => $value->AZSCode,
                ])->save();
            }
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'Заливы успешно сохранены',
        ]);
    }
}