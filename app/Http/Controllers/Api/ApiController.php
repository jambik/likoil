<?php

namespace App\Http\Controllers\Api;

use App\Card;
use App\Discount;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function maxId()
    {
        $maxDiscountId = DB::table('discounts')->max('DiscountID');
        $maxDiscountCardId = DB::table('cards')->max('DiscountCardID');
        $maxTransactionId = DB::table('cards')->max('TransactionID');

        return response()->json([
            'response' => [
                'MaxDiscountId' => $maxDiscountId,
                'MaxDiscountCardId' => $maxDiscountCardId,
                'MaxTransactionId' => $maxTransactionId,
            ]
        ]);
    }

    public function cardsSave(Request $request)
    {
        $this->validate($request, [
            'data' => 'required'
        ]);

        $data = $request->get('data');

        $jsonObj = json_decode($data);

        if(count($jsonObj->DocumentElement->dcDiscountCard) == 1)
        {
            Card::create([
                'DiscountCardID' => $jsonObj->DocumentElement->dcDiscountCard->DiscountCardID,
                'Code' => $jsonObj->DocumentElement->dcDiscountCard->Code,
                'TransactionID' => $jsonObj->DocumentElement->dcDiscountCard->TransactionID,
            ])->save();
        }
        else
        {
            foreach($jsonObj->DocumentElement->dcDiscountCard as $value)
            {
                Card::create([
                    'DiscountCardID' => $value->DiscountCardID,
                    'Code' => $value->Code,
                    'TransactionID' => $value->TransactionID,
                ])->save();
            }
        }

        return response()->json([
            'response' => [
                'status' => 'ok',
                'message' => 'Карты успешно сохранены',
            ],
        ]);
    }

    public function discountsSave(Request $request)
    {
        $this->validate($request, [
            'data' => 'required'
        ]);

        $data = $request->get('data');

        $jsonObj = json_decode($data);

        if(count($jsonObj->DocumentElement->rgDiscount) == 1)
        {
            Discount::create([
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
            foreach($jsonObj->DocumentElement->rgDiscount as $value)
            {
                Discount::create([
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
            'response' => [
                'status' => 'ok',
                'message' => 'Заливы успешно сохранены',
            ],
        ]);
    }
}
