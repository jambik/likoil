<?php

namespace App\Http\Controllers\Api;

use App\Card;
use App\CardInfo;
use App\Feedback;
use App\GasStation;
use App\Http\Controllers\ApiController;
use App\News;
use App\User;
use App\Withdrawal;
use Auth;
use Illuminate\Http\Request;
use Mail;

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
     *          description="Номер карты (6 символов)",
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
            'card' => 'required|size:6',
        ]);

        $card = Card::where('code', 'LIKE', '%'.$request->get('card').'_')->first();

        if( ! $card) {
            return response()->json([
                'error' => 'Карта не найдена',
            ], 404);
        }

        if( ! $card->info || ! $card->info->phone) {
            return response()->json([
                'error' => 'К данной карте не привязан телефон. Обратитесь по номеру: +7988-000-00-00',
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
                'email' => $card->code,
                'password' => bcrypt($password),
                'api_token' => str_random(60),
            ]);

            $card->info->user()->associate($user);
            $card->info->save();
        }

        include base_path('library/epochtasms/index.php');

        // Отправляем СМС
        $res = $Stat->sendSMS("Likoil", "login: " . $card->code . "\npass: " . $password, '+7'.$card->info->phone, "", 0);

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
     *          description="Логин - номер карты",
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
     * Отправка данных для Push уведомлений
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *     path="/user/push",
     *     summary="Отправка данных для Push уведомлений",
     *     tags={"User"},
     *     description="Отправка данных для Push уведомлений",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="api_token",
     *          description="API Token",
     *          type="string",
     *          required=true,
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="device",
     *          description="Устройство",
     *          type="string",
     *          enum={"ios", "android"},
     *          required=true,
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="device_token",
     *          description="Token устройства",
     *          type="string",
     *          required=true,
     *          in="query"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Успешный запрос",
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
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="Входные параметры заполнены неверно"
     *     ),
     * )
     */
    public function push(Request $request)
    {
        $this->validate($request, [
            'device' => 'required|in:ios,android',
            'device_token' => 'required',
        ]);

        // save device and device_token
        Auth::user()->update([
            'device' => $request->get('device'),
            'device_token' => $request->get('device_token'),
        ]);

        Auth::user()->device = $request->get('device');
        Auth::user()->device_token = $request->get('device_token');
        Auth::user()->saveOrFail();

        return response()->json([
            'info' => 'Данные сохранены',
        ]);
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
     *                 property="points",
     *                 type="integer",
     *                 description="Общее количество заработанных бонусов"
     *             ),
     *             @SWG\Property(
     *                 property="withdrawals",
     *                 type="integer",
     *                 description="Общее количество потраченных бонусов"
     *             ),
     *             @SWG\Property(
     *                 property="discounts_count",
     *                 type="integer",
     *                 description="Общее количество заливов"
     *             ),
     *             @SWG\Property(
     *                 property="discounts_volume",
     *                 type="number",
     *                 format="float",
     *                 description="Общий объем залитого топлива"
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
        $response['points'] = $cardInfo->card->total_points;
        $response['withdrawals'] = $cardInfo->card->total_withdrawals;
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
     *             @SWG\Property(
     *                 property="count",
     *                 type="integer",
     *                 description="Количество использования балов",
     *             ),
     *             @SWG\Property(
     *                 property="total",
     *                 type="integer",
     *                 description="Общая сумма использованных баллов",
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
        $withdrawals = Withdrawal::where('card_id', $card->card_id)->orderBy('use_at', 'desc')->get();

        $response['withdrawals'] = $withdrawals;
        $response['count'] = $withdrawals->count();
        $response['total'] = $withdrawals->sum('amount');

        return response()->json(
            $response
        );
    }

    /**
     * Заливы по карте
     *
     * @param Request $request
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
     *      @SWG\Parameter(
     *          name="start",
     *          description="Дата от (YYYY-MM-DD)",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="end",
     *          description="Дата до (YYYY-MM-DD)",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="stat",
     *          description="Только статистика",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Response(
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
     *             @SWG\Property(
     *                 property="count",
     *                 type="integer",
     *                 description="Количество заливов",
     *             ),
     *             @SWG\Property(
     *                 property="amount",
     *                 type="integer",
     *                 description="Общая сумма",
     *             ),
     *             @SWG\Property(
     *                 property="points",
     *                 type="integer",
     *                 description="Заработанные баллы",
     *             ),
     *         )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     )
     * )
     */
    public function discounts(Request $request)
    {
        $this->validate($request, [
            'start' => 'date|date_format:Y-m-d|before:end',
            'end'   => 'date|date_format:Y-m-d|after:start',
        ]);

        $cardInfo = CardInfo::with('card')->where('user_id', Auth::id())->firstOrFail();

        $discounts = $cardInfo->card->discounts()->orderBy('date', 'desc')->get();

        if ($request->has('start')) {
            $discounts = $discounts->where('date', '>=', $request->get('start'));
            $discounts = $discounts->where('date', '<=', $request->get('end'));
        }

        $discounts = $discounts->values();

        if ($discounts->count()) {
            $gasStations = GasStation::all();
            $gasStationsAddress = null;

            foreach ($gasStations as $item) {
                if ($item->code) {
                    $codes = explode(',', $item->code);
                    foreach ($codes as $value) {
                        $gasStationsAddress[(int)trim($value)] = $item->city . ', ' . $item->address;
                    }
                }
            }

            foreach ($discounts as $value) {
                $value->azs_address = isset($gasStationsAddress[$value->azs]) ? $gasStationsAddress[$value->azs] : '';
            }
        }

        $response = [
            'discounts' => $discounts,
            'count'  => $discounts->count(),
            'amount' => $discounts->sum('amount'),
            'points' => $discounts->sum('point'),
        ];

        if ($request->has('stat') && $request->get('stat')) {
            unset($response['discounts']);
        }

        return response()->json($response);
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

    /**
     * Список АЗС
     *
     * @return Response
     *
     * @SWG\Get(
     *     path="/user/news",
     *     summary="Новости",
     *     tags={"User"},
     *     description="Список всех новостей",
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
     *                 property="news",
     *                 type="array",
     *                 description="Новости",
     *                 @SWG\Items(
     *                     ref="#/definitions/News"
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
    public function news()
    {
        $news = News::all();

        return response()->json([
            'news' => $news,
        ]);
    }

    /**
     * Отзыв
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *     path="/user/feedback",
     *     summary="Отзыв",
     *     tags={"User"},
     *     description="Отзыв",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="api_token",
     *          description="API Token",
     *          type="string",
     *          required=true,
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="message",
     *          description="Сообщение",
     *          type="string",
     *          required=true,
     *          in="formData"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="info",
     *                 type="string",
     *                 description="Ответ"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthenticated"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="Входные параметры заполнены неверно"
     *     )
     * )
     */
    public function feedback(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
        ]);

        Feedback::create([
            'message' => $request->get('message'),
            'user_id' => Auth::id(),
        ]);

        $data = [
            'text' => $request->get('message'),
            'user' => Auth::user(),
        ];

        Mail::send(['text' => 'emails.feedback'], $data, function ($message) {
            $message->to('jambik@gmail.com');
            $message->subject('Отзыв о приложении');
        });

        return response()->json([
            'info' => 'Отзыв сохранен',
        ]);
    }
}
