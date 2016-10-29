<?php

namespace App\Http\Controllers\Api;

use App\CardInfo;
use App\Http\Controllers\ApiController;
use Auth;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Авторизация и получение api_token
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *     path="/user/auth",
     *     summary="Авторизация",
     *     tags={"User"},
     *     description="Авторизация и получение api_token",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="email",
     *          description="Логин (Телефон - 10 цифр)",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="password",
     *          description="Пароль",
     *          type="string",
     *          required=true,
     *          in="query"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="успешная авторизация",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="api_token",
     *                 type="string",
     *                 description="Api Token"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="Входные параметры заполнены неверно"
     *     ),
     * )
     */
    public function authorizeAndGetToken(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::validate($request->all())) {
            return response()->json([
                'api_token' => Auth::getLastAttempted()->api_token
            ]);
        }

        return response('Unauthorized.', 401);
    }

    /**
     * Информация о карте
     *
     * @return Response
     *
     * @SWG\Get(
     *     path="/user/info",
     *     summary="Информация о карте",
     *     tags={"User"},
     *     description="Информация о владельце карты, количестве бонусов, сумме заливов и т.д.",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="api_token",
     *          description="API Token",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="bonus",
     *                 type="integer",
     *                 description="Количество бонусов"
     *             ),
     *             @SWG\Property(
     *                 property="discounts_count",
     *                 type="integer",
     *                 description="Количество заливов по карте"
     *             ),
     *             @SWG\Property(
     *                 property="discounts_volume",
     *                 type="number",
     *                 format="float",
     *                 description="Объем залитого топлива"
     *             ),
     *             @SWG\Property(
     *                 property="discounts_sum",
     *                 type="integer",
     *                 description="Сумма всех заливов"
     *             ),
     *             @SWG\Property(
     *                 property="card_info",
     *                 ref="#/definitions/CardInfo"
     *             ),
     *         )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @SWG\Response(
     *          response=404,
     *          description="Информация о карта не найдена"
     *     )
     * )
     */
    public function info()
    {
        $cardInfo = CardInfo::with('card')->where('user_id', Auth::id())->firstOrFail();

        $response['bonus'] = $cardInfo->card->bonus;
        $response['discounts_count'] = $cardInfo->card->discounts->count();
        $response['discounts_volume'] = $cardInfo->card->discounts->sum('volume');
        $response['discounts_sum'] = $cardInfo->card->discounts->sum('amount');
        unset($cardInfo->card);
        $response['info'] = $cardInfo;

        return response()->json(
            $response
        );
    }

    /**
     * Заливы по карте
     *
     * @return Response
     *
     * @SWG\Get(
     *     path="/user/discounts",
     *     summary="Заливы по карте",
     *     tags={"User"},
     *     description="Список всех заливов по дисконтной карте",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="api_token",
     *          description="API Token",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="discounts",
     *                 type="array",
     *                 description="Информация о заливе",
     *                 @SWG\Items(
     *                     ref="#/definitions/Discount"
     *                 )
     *             ),
     *         )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     )
     * )
     */
    public function discounts()
    {
        $cardInfo = CardInfo::with('card')->where('user_id', Auth::id())->firstOrFail();

        $response['discounts'] = $cardInfo->card->discounts;

        return response()->json(
            $response
        );
    }
}
