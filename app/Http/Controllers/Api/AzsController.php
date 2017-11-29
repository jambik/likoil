<?php

namespace App\Http\Controllers\Api;

use App\Card;
use App\Http\Controllers\ApiController;
use App\Settings;
use App\Withdrawal;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AzsController extends ApiController
{

    /**
     * Настройки
     *
     * @return Response
     *
     * @SWG\Get(
     *     path="/settings",
     *     summary="Настройки",
     *     tags={"AZS"},
     *     description="Настройки для программы",
     *     produces={"application/json"},
     *     security={{"basic":{}}},
     *     @SWG\Response(
     *         response=200,
     *         description="Настройки",
     *         @SWG\Schema(
     *
     *             type="object",
     *             @SWG\Property(
     *                 property="response",
     *                 type="object",
     *                 description="корневой объект",
     *                 @SWG\Property(
     *                     property="step",
     *                     type="integer",
     *                     description="Шаг для увеличения/уменьшения баллов"
     *                 ),
     *                 @SWG\Property(
     *                     property="min",
     *                     type="integer",
     *                     description="Минимальный порог"
     *                 ),
     *                 @SWG\Property(
     *                     property="max",
     *                     type="integer",
     *                     description="Максимальный порог"
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
    public function settings()
    {
        $settings = Settings::find(1);

        return response()->json([
            'response' => [
                'step' => $settings->step,
                'min' => $settings->min,
                'max' => $settings->max,
            ]
        ]);
    }

    /**
     * Информация о карте
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *     path="/card/info",
     *     summary="Информация о карте",
     *     tags={"AZS"},
     *     description="Информация о бонусной карте",
     *     produces={"application/json"},
     *     security={{"basic":{}}},
     *     @SWG\Parameter(
     *          name="card",
     *          description="Номер карты",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Карта найдена",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="response",
     *                 type="object",
     *                 description="корневой объект",
     *                 @SWG\Property(
     *                     property="points",
     *                     type="integer",
     *                     description="Количество бонусов"
     *                 ),
     *                 @SWG\Property(
     *                     property="card_id",
     *                     type="integer",
     *                     description="Id карты"
     *                 ),
     *                 @SWG\Property(
     *                     property="code",
     *                     type="string",
     *                     description="Номер карты"
     *                 ),
     *                 @SWG\Property(
     *                     property="card_info",
     *                     ref="#/definitions/CardInfo"
     *                 ),
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @SWG\Response(
     *          response=404,
     *          description="Карта не найдена"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="Неправильные входные данные"
     *     ),
     * )
     */
    public function cardInfo(Request $request)
    {
        $this->validate($request, [
            'card' => 'required',
        ]);

        $card = Card::where('code', $request->get('card'))->first();

        if (! $card) {
            return response()->json([
                'response' => [
                    'message' => 'Карта с номером ' . $request->get('card') . ' не найдена',
                ]
            ], 404);
        }

        return response()->json([
            'response' => [
                'points' => $card->is_blocked ? 0 : $card->bonus,
                'card_id' => $card->id,
                'code' => $card->code,
                'card_info' => $card->info,
            ],
        ]);
    }

    /**
     * Использование бонусов
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *     path="/card/withdraw",
     *     summary="Использование бонусов",
     *     tags={"AZS"},
     *     description="Использование бонусов с бонусной карты",
     *     produces={"application/json"},
     *     security={{"basic":{}}},
     *     @SWG\Parameter(
     *         name="card",
     *         description="Номер карты",
     *         type="string",
     *         required=true,
     *         in="query"
     *     ),
     *     @SWG\Parameter(
     *         name="amount",
     *         description="Количество бонусов",
     *         type="integer",
     *         required=true,
     *         in="query"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Бонус списан",
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
     *                 @SWG\Property(
     *                     property="receipt_id",
     *                     type="integer",
     *                     description="Id квитанции"
     *                 ),
     *                 @SWG\Property(
     *                     property="card_id",
     *                     type="integer",
     *                     description="Id карты"
     *                 ),
     *                 @SWG\Property(
     *                     property="code",
     *                     type="string",
     *                     description="Номер карты"
     *                 ),
     *                 @SWG\Property(
     *                     property="azs_name",
     *                     type="string",
     *                     description="Место выдачи"
     *                 ),
     *                 @SWG\Property(
     *                     property="card_info",
     *                     ref="#/definitions/CardInfo"
     *                 )
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @SWG\Response(
     *          response=404,
     *          description="Карта не найдена"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="Неправильные входные данные"
     *     ),
     * )
     */
    public function cardWithdraw(Request $request)
    {
        $this->validate($request, [
            'card' => 'required',
            'amount' => 'required|integer',
        ]);

        $card = Card::where('code', $request->get('card'))->first();

        if ( ! $card) {
            return response()->json([
                'response' => [
                    'message' => 'Карта с номером ' . $request->get('card') . ' не найдена',
                ]
            ], 404);
        }

        $instance = Withdrawal::create([
            'card_id' => $card->id,
            'amount' => $request->get('amount'),
            'type' => 'Использование бонусов',
            'azs' => Auth::user()->name,
            'use_at' => Carbon::now(),
        ]);

        return response()->json([
            'response' => [
                'status' => 'ok',
                'message' => 'Бонус успешно списан с карты',
                'receipt_id' => $instance->id,
                'card_id' => $card->id,
                'code' => $card->code,
                'azs_name' => Auth::user()->name,
                'card_info' => $card->info,
            ],
        ]);
    }
}
