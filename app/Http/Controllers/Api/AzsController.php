<?php

namespace App\Http\Controllers\Api;

use App\Card;
use App\Discount;
use App\Http\Controllers\ApiController;
use App\Settings;
use App\Withdrawal;
use Auth;
use Carbon\Carbon;
use DB;
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
     *                     property="card",
     *                     type="string",
     *                     description="Номер карты"
     *                 ),
     *                 @SWG\Property(
     *                     property="points",
     *                     type="integer",
     *                     description="Количество бонусов"
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
                'card' => $card->code,
                'points' => $card->bonus,
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

        if (! $card) {
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
            'azs' => Auth::user()->id,
            'use_at' => Carbon::now(),
        ]);

        return response()->json([
            'response' => [
                'status' => 'ok',
                'message' => 'Бонус успешно списан с карты',
            ],
        ]);
    }
}
