<?php

namespace App\Http\Controllers\Api;

use App\Card;
use App\Discount;
use App\Http\Controllers\ApiController;
use DB;
use Illuminate\Http\Request;

class ImportController extends ApiController
{

    /**
     * Максимальные значения ключей
     *
     * @return Response
     *
     * @SWG\Get(
     *     path="/maxid",
     *     summary="Максимальные значения ключей",
     *     tags={"Topaz"},
     *     description="Максимальные значения ключей",
     *     produces={"application/json"},
     *     security={{"basic":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="Максимальные ключи",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="response",
     *                 type="object",
     *                 description="корневой объект",
     *                 @SWG\Property(
     *                     property="MaxDiscountId",
     *                     type="integer",
     *                     description="Максимальный ID залива"
     *                 ),
     *                 @SWG\Property(
     *                     property="MaxDiscountCardId",
     *                     type="integer",
     *                     description="Максимальный ID карты"
     *                 ),
     *                 @SWG\Property(
     *                     property="MaxTransactionId",
     *                     type="integer",
     *                     description="Максимальный ID транзакции"
     *                 ),
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     * )
     */
    public function maxId()
    {
        $maxDiscountId = DB::table('discounts')->max('id');
        $maxDiscountCardId = DB::table('cards')->max('id');
        $maxTransactionId = DB::table('cards')->max('transaction_id');

        return response()->json([
            'response' => [
                'MaxDiscountId' => $maxDiscountId,
                'MaxDiscountCardId' => $maxDiscountCardId,
                'MaxTransactionId' => $maxTransactionId,
            ]
        ]);
    }

    /**
     * Сохранение карт
     *
     * @return Response
     *
     * @SWG\Post(
     *     path="/cards/save",
     *     summary="Сохранение карт",
     *     tags={"Topaz"},
     *     description="Сохранение дисконтных карт",
     *     produces={"application/json"},
     *     security={{"basic":{}}},
     *     @SWG\Parameter(
     *          name="data",
     *          description="Данные о картах",
     *          type="string",
     *          required=true,
     *          in="formData"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Карты успешно сохранены",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="response",
     *                 type="object",
     *                 description="корневой объект",
     *                 @SWG\Property(
     *                     property="status",
     *                     type="string",
     *                     description="Статус запроса"
     *                 ),
     *                 @SWG\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Сообщение"
     *                 ),
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="Неправильные входные данные"
     *     ),
     * )
     */
    public function cardsSave(Request $request)
    {
        $this->validate($request, [
            'data' => 'required|json',
        ]);

        $jsonObj = json_decode($request->get('data'));

        if(count($jsonObj->DocumentElement->dcDiscountCard) === 1)
        {
            $attributes = [
                'id' => $jsonObj->DocumentElement->dcDiscountCard->DiscountCardID,
            ];

            $values = [
                'code' => $jsonObj->DocumentElement->dcDiscountCard->Code,
                'transaction_id' => $jsonObj->DocumentElement->dcDiscountCard->TransactionID,
            ];

            Card::updateOrCreate($attributes, $values);
        }
        else
        {

            foreach($jsonObj->DocumentElement->dcDiscountCard as $value)
            {
                $attributes = [
                    'id' => $value->DiscountCardID,
                ];

                $values = [
                    'code' => $value->Code,
                    'transaction_id' => $value->TransactionID,
                ];

                Card::updateOrCreate($attributes, $values);
            }
        }

        return response()->json([
            'response' => [
                'status' => 'ok',
                'message' => 'Карты успешно сохранены',
            ],
        ]);
    }

    /**
     * Сохранение заливов
     *
     * @return Response
     *
     * @SWG\Post(
     *     path="/discounts/save",
     *     summary="Сохранение заливов",
     *     tags={"Topaz"},
     *     description="Сохранение заливов",
     *     produces={"application/json"},
     *     security={{"basic":{}}},
     *     @SWG\Parameter(
     *          name="data",
     *          description="Данные о заливах",
     *          type="string",
     *          required=true,
     *          in="formData"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Заливы успешно сохранены",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="response",
     *                 type="object",
     *                 description="корневой объект",
     *                 @SWG\Property(
     *                     property="status",
     *                     type="string",
     *                     description="Статус запроса"
     *                 ),
     *                 @SWG\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Сообщение"
     *                 ),
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="Неправильные входные данные"
     *     ),
     * )
     */
    public function discountsSave(Request $request)
    {
        $this->validate($request, [
            'data' => 'required|json',
        ]);

        $jsonObj = json_decode($request->get('data'));

        if(count($jsonObj->DocumentElement->rgDiscount) === 1)
        {
            Discount::import($jsonObj->DocumentElement->rgDiscount);
        }
        else
        {
            foreach($jsonObj->DocumentElement->rgDiscount as $value) {
                Discount::import($value);
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
