<?php

namespace App\Http\Controllers\Api;

use App\Card;
use App\CardInfo;
use App\GasStation;
use App\Http\Controllers\ApiController;
use App\User;
use App\Withdrawal;
use Auth;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Получение пароля по sms
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *     path="/user/getpassword",
     *     summary="Получение пароля",
     *     tags={"User"},
     *     description="Получение пароля по sms",
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
     *         description="успешный запрос на получение пароля по sms",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="info",
     *                 type="string",
     *                 description="Ответ успешного запроса"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *          response=404,
     *          description="Карта не найдена",
     *          @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="error",
     *                 type="string",
     *                 description="Описание ошибки"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="Входные параметры заполнены неверно"
     *     ),
     * )
     */
    public function getPassword(Request $request)
    {
        $this->validate($request, [
            'card' => 'required',
        ]);

        $card = Card::whereCode($request->get('card'))->first();

        if( ! $card) {
            return response()->json([
                'error' => 'Карта не найдена',
            ], 404);
        }

        if( ! $card->info || ! $card->info->phone) {
            return response()->json([
                'error' => 'К данной карте не привязан телефон. Обратитесь по номеру: +7988-000-000-00',
            ], 404);
        }

        $password = $card->info->password;

        if ( ! $card->info->user) {
            $password = random_int(100000, 999999);

            $card->info()->update([
                'password' => $password,
            ]);

            $user = User::create([
                'name' => trim($card->info->last_name . ' ' . $card->info->name . ' ' . $card->info->patronymic),
                'email' => $request->get('card'),
                'password' => bcrypt($password),
                'api_token' => str_random(60),
            ]);

            $card->info->user()->associate($user);
            $card->info->save();
        }

        include base_path('library/epochtasms/index.php');

        // Отправляем СМС
        $res = $Stat->sendSMS("Likoil", "логин: " . $card->code . "\nпароль: " . $password, '+7'.$card->info->phone, "", 0);

        if (isset($res["result"]["error"])) {
            return response()->json([
                'error' => 'Ошибка при отправке СМС: ' . $res["result"]["code"],
            ], 400);
        }

        return response()->json([
            'info' => 'Sms отправлена на номер: '.$card->info->phone,
        ]);
    }

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
     * Информация о карте
     *
     * @return Response
     *
     * @SWG\Get(
     *     path="/user/withdrawals",
     *     summary="Списанные баллы",
     *     tags={"User"},
     *     description="Список снятых баллов",
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
     *                 property="withdrawals",
     *                 type="array",
     *                 description="Информация о списании",
     *                 @SWG\Items(
     *                     ref="#/definitions/Withdrawal"
     *                 )
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
    public function withdrawals()
    {
        $card = CardInfo::where('user_id', Auth::id())->firstOrFail();
        $withdrawals = Withdrawal::where('card_id', $card->card_id)->get();

        $response['withdrawals'] = $withdrawals;

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

    /**
     * Список АЗС
     *
     * @return Response
     *
     * @SWG\Get(
     *     path="/user/gas_stations",
     *     summary="Список всех АЗС",
     *     tags={"User"},
     *     description="Список всех АЗС",
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
     *                 property="gas_stations",
     *                 type="array",
     *                 description="Список АЗС",
     *                 @SWG\Items(
     *                     ref="#/definitions/GasStation"
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
    public function gasStations()
    {
        $gasStations = GasStation::all();

        $response['gas_stations'] = $gasStations;

        return response()->json(
            $response
        );
    }
}
