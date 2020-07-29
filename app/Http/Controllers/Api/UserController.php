<?php

namespace App\Http\Controllers\Api;

use App\Bonus;
use App\Card;
use App\CardInfo;
use App\Feedback;
use App\GasStation;
use App\Http\Controllers\ApiController;
use App\News;
use App\OilChange;
use App\User;
use App\Withdrawal;
use Auth;
use Illuminate\Http\Request;
use Mail;
use Telegram\Bot\Laravel\Facades\Telegram;

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
     *     @SWG\Parameter(
     *          name="phone",
     *          description="Телефон (10 символов)",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="name",
     *          description="Имя",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="успешный запрос на получение пароля по sms",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="card",
     *                 type="string",
     *                 description="Номер карты"
     *             ),
     *             @SWG\Property(
     *                 property="info",
     *                 type="string",
     *                 description="Ответ успешного запроса"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *          response=400,
     *          description="Ошибка в запросе"
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
            'phone' => 'required|size:10',
        ]);

        $card = Card::where('code', 'LIKE', '%'.$request->get('card').'_')->first();

        if( ! $card) {
            return response()->json([
                'error' => 'Карта не найдена',
            ], 404);
        }

        // Если к данной карте не привязан телефон выдаем ошибку
        if ( ! $card->info || ! $card->info->phone) {
            return response()->json([
                'error' => 'К данной карте не привязан номер телефона',
            ], 400);
        }

        // Если в запросе присутствует телефон
//        if ($request->exists('phone')) {
            // Если анкета заполнена и телефоны не совпадают
            if ($card->info->phone != $request->get('phone')) {
                return response()->json([
                    'error' => 'К данной карте уже привязан другой телефон',
                    //'error' => 'К данной карте уже привязан другой телефон: ' . $card->info->phone,
                ], 400);
            }

            // Если есть анкета, то обновляем телефон
            if ($card->info()->count()) {
                $card->info()->update([
                    'phone' => $request->get('phone'),
                    'name' => $request->exists('name') && $request->get('name') ? $request->get('name') : $card->info->name,
                ]);
            // Если нет анкеты то создаем ее с телефоном и пустым паролем
            } else {
                $card->info()->create([
                    'phone' => $request->get('phone'),
                    'password' => '',
                    'name' => $request->exists('name') && $request->get('name') ? $request->get('name') : '',
                ]);
            }
            $card->load('info');
        // Если в запросе отсутсвует телефон и анкета не заполнена
//        } elseif ( ! $card->info || ! $card->info->phone) {
//            return response()->json([
//                'error' => 'К данной карте не привязан номер телефона',
//            ], 400);
//        }

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
        $res = $Stat->sendSMS("Likoil", "Likoil: " . $password, '+7'.$card->info->phone, "", 0);

        if (isset($res["result"]["error"])) {
            return response()->json([
                'error' => 'Ошибка при отправке СМС: ' . $res["result"]["code"],
            ], 400);
        }

        return response()->json([
            'card' => $card->code,
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
     *                 property="info",
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
        $response['bonuses'] = $cardInfo->card->total_bonuses;
        $response['withdrawals'] = $cardInfo->card->total_withdrawals;
//        $response['oil_changes'] = $cardInfo->card->oilChanges;
        $response['discounts_count'] = $cardInfo->card->discounts->count();
        $response['discounts_volume'] = $cardInfo->card->discounts->sum('volume');
        $response['discounts_sum'] = $cardInfo->card->discounts->sum('amount');
        $cardInfo->card_number = $cardInfo->card->code;
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
     *     path="/user/bonuses",
     *     summary="Добавленные Администратором баллы",
     *     tags={"User"},
     *     description="Добавленные Администратором баллы",
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
     *                 property="bonuses",
     *                 type="array",
     *                 description="Добавленные Администратором баллы",
     *                 @SWG\Items(
     *                     ref="#/definitions/Bonus"
     *                 )
     *             ),
     *             @SWG\Property(
     *                 property="total",
     *                 type="integer",
     *                 description="Общая сумма добавленных баллов",
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
    public function bonuses()
    {
        $card = CardInfo::where('user_id', Auth::id())->firstOrFail();
        $bonuses = Bonus::where('card_id', $card->card_id)->latest()->get();

        $response['bonuses'] = $bonuses;
        $response['total'] = $bonuses->sum('amount');

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
     * Список новостей
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

        $news->transform(function ($item, $key) {
            $item['is_read'] = $item->users()->get()->find(auth()->id()) ? 1 : 0;
            return $item;
        });

        return response()->json([
            'news' => $news,
        ]);
    }

    /**
     * Изменение статуса новости
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *     path="/user/news_read",
     *     summary="Изменение статуса новости",
     *     tags={"User"},
     *     description="Изменение статуса новости на - прочитано",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="api_token",
     *          description="API Token",
     *          type="string",
     *          required=true,
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="id",
     *          description="ID новости",
     *          type="integer",
     *          required=true,
     *          in="query"
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
    public function newsRead(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);


        $news = News::findOrFail($request->get('id'));

        auth()->user()->news()->syncWithoutDetaching([$news->id]);

        return response()->json([
            'info' => 'Статус новости обновлен',
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
            $message->to('nmm888@gmail.com');
            $message->subject('Отзыв о приложении');
        });

        $telegramMessage = "Отправлено сообщение с мобильного приложения
Пользователь: " . Auth::user()->name . "
Номер карты: " . Auth::user()->cardInfo->card->code . "
Телефон: +7" . Auth::user()->cardInfo->phone ."

Сообщение:
" . $request->get('message');

        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID'),
            'text' => $telegramMessage,
        ]);

        return response()->json([
            'info' => 'Отзыв сохранен',
        ]);
    }

    /**
     * Замена масла
     *
     * @return Response
     *
     * @SWG\Get(
     *     path="/user/oil_changes",
     *     summary="Замена масла",
     *     tags={"User"},
     *     description="Список Замен масла",
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
     *                 property="oil_changes",
     *                 type="array",
     *                 description="Замена масла",
     *                 @SWG\Items(
     *                     ref="#/definitions/OilChange"
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
    public function oilChanges()
    {
        $oil_changes = OilChange::where('card_id', Auth::user()->cardInfo->card->id)->get();

        return response()->json([
            'oil_changes' => $oil_changes,
        ]);
    }

    /**
     * Добавление Замены масла
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *     path="/user/oil_changes/add",
     *     summary="Добавление замены масла",
     *     tags={"User"},
     *     description="Добавление замены масла",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="api_token",
     *          description="API Token",
     *          type="string",
     *          required=true,
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="mileage",
     *          description="Пробег",
     *          type="integer",
     *          required=true,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="change_at",
     *          description="Дата замены масла (YYYY-MM-DD)",
     *          type="string",
     *          required=false,
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
    public function addOilChange(Request $request)
    {
        $this->validate($request, [
            'mileage' => 'required|numeric',
            'change_at' => 'date',
        ]);

        $data = [
            'card_id' => Auth::user()->cardInfo->card->id,
            'mileage' => $request->get('mileage'),
            'change_at' => $request->exists('change_at') && $request->get('change_at') ? $request->get('change_at') : date('Y-m-d'),
        ];

        OilChange::create($data);

        return response()->json([
            'info' => 'Данные сохранены',
        ]);
    }

    /**
     * Добавление Замены масла
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *     path="/user/oil_changes/update",
     *     summary="Изменение замены масла",
     *     tags={"User"},
     *     description="Изменение записи о замене масла",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="api_token",
     *          description="API Token",
     *          type="string",
     *          required=true,
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="id",
     *          description="ID записи",
     *          type="integer",
     *          required=true,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="mileage",
     *          description="Пробег",
     *          type="integer",
     *          required=true,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="change_at",
     *          description="Дата замены масла (YYYY-MM-DD)",
     *          type="string",
     *          required=false,
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
    public function updateOilChange(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'mileage' => 'numeric',
            'change_at' => 'date',
        ]);

        $data = [
            'mileage' => $request->get('mileage'),
            'change_at' => $request->exists('change_at') && $request->get('change_at') ? $request->get('change_at') : date('Y-m-d'),
        ];

        $oilChange = OilChange::findOrFail($request->get('id'));

        $oilChange->update($data);

        return response()->json([
            'info' => 'Данные обновлены',
        ]);
    }

    /**
     * Удаление Замены масла
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *     path="/user/oil_changes/delete",
     *     summary="Удаление замены масла",
     *     tags={"User"},
     *     description="Удаление замены масла",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="api_token",
     *          description="API Token",
     *          type="string",
     *          required=true,
     *          in="query"
     *     ),
     *     @SWG\Parameter(
     *          name="id",
     *          description="ID записи",
     *          type="integer",
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
    public function deleteOilChange(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        OilChange::destroy($request->get('id'));

        return response()->json([
            'info' => 'Запись удалена',
        ]);
    }
}
