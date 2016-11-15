<?php

namespace App\Http\Controllers\Admin;

use App\Card;
use App\Http\Controllers\BackendController;
use App\User;
use Flash;
use Illuminate\Http\Request;

class CardsController extends BackendController
{
    protected $resourceName = null;

    protected $model = null;

    public function __construct()
    {
        $this->resourceName = 'cards';
        $this->model = new Card();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {

            $draw = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');

            $recordsTotal = $this->model->count();
            $recordsFiltered = $recordsTotal;

            $columns = $request->get('columns');
            $order = $request->get('order');
            $search = $request->get('search');

            $query = $this->model->with('info')->select('*');

            // Поиск
            if ($search['value']) {
                $query->where('code', 'LIKE', '%'.$search['value'].'%');
                $query->orWhereHas('info', function($q) use ($search) {
                    $q->where('name', 'LIKE', '%'.$search['value'].'%');
                });
                $query->orWhereHas('info', function($q) use ($search) {
                    $q->where('last_name', 'LIKE', '%'.$search['value'].'%');
                });
                $query->orWhereHas('info', function($q) use ($search) {
                    $q->where('phone', 'LIKE', '%'.$search['value'].'%');
                });

                $recordsFiltered = $query->count();
            }

            // Добавление пагинации
            $query->skip($start)->limit($length);

            // Добавление сортировки по колонкам
            foreach ($order as $orderColumn) {
                $query->orderBy($columns[$orderColumn['column']]['data'], $orderColumn['dir']);
            }

            // Выбираем записи
            $items = $query->get();
//            dd($items->toArray());

            // Добавляем к каждой записи дополнительное поле row_<ID> для плагина DataTables
            $items = $items->map(function ($item, $key) {
                $item['DT_RowId'] = 'row_' . $item->id;
                return $item;
            });

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $items,
            ]);
        }

//        $items = $this->model->with('discounts', 'withdrawals')->limit(100)->get();

        return view('admin.'.$this->resourceName.'.index'/*, compact('items')*/);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.'.$this->resourceName.'.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|unique',
        ]);

        $input = $request->all();

        foreach (['verified'] as $value) $input[$value] = $request->has($value) ? true : false;

        $this->model->create($input);

        return redirect(route('admin.'.$this->resourceName.'.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $item = $this->model->findOrFail($id);

        return view('admin.'.$this->resourceName.'.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|unique:' . $this->model->getTable() . ',code,'.$id,
        ]);

        $item = $this->model->findOrFail($id);

        $input = $request->all();

        foreach (['verified'] as $value) $input[$value] = $request->has($value) ? true : false;

        $item->update($input);

        return redirect(route('admin.'.$this->resourceName.'.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->model->destroy($id);

        return redirect(route('admin.'.$this->resourceName.'.index'));
    }

    public function showInfo($id)
    {
        $card = $this->model->findOrFail($id);

        return view('admin.'.$this->resourceName.'.info', compact('card'));
    }

    public function saveInfo(Request $request, $id)
    {
        $item = $this->model->findOrFail($id);

        $this->validate($request, [
            'info.name' => 'required',
            'info.phone' => 'required|size:10|unique:cards_info,phone' . ($item->info ? ',' . $item->info->card_id . ',card_id' : ''),
        ]);

        $data = $request->get('info');

        foreach (['birthday_at', 'issued_at', 'document_at'] as $value) $data[$value] = $data[$value] ?: null;

        if ($item->info()->count()) {
            $item->info()->update($data);
        } else {
            $item->info()->create($data);
        }

        Flash::success("Запись #{$item->id} обновлена");

        return redirect(route('admin.'.$this->resourceName.'.index'));
    }

    public function showLogin($id)
    {
        $card = $this->model->findOrFail($id);

        return view('admin.'.$this->resourceName.'.login', compact('card'));
    }

    public function saveLogin(Request $request, $id)
    {
        $item = $this->model->findOrFail($id);

        $this->validate($request, [
            'login' => 'required|size:10|unique:users,email' . ($item->info->user ? ',' . $item->info->user->id : ''),
            'password' => 'required|min:4',
        ]);

        $item->info()->update([
            'phone' => $request->get('login'),
            'password' => $request->get('password'),
        ]);

        if ($item->info->user) {
            $item->info->user()->update([
                'email' => $request->get('login'),
                'password' => bcrypt($request->get('password')),
            ]);

            if ($request->get('password') !== $item->info->password) {
                $item->info->user()->update([
                    'api_token' => str_random(60),
                ]);
            }
        } else {
            $user = User::create([
                'name' => trim($item->info->last_name . ' ' . $item->info->name . ' ' . $item->info->patronymic),
                'email' => $request->get('login'),
                'password' => bcrypt($request->get('password')),
                'api_token' => str_random(60),
            ]);

            $item->info->user()->associate($user);
            $item->info->save();
        }

        Flash::success("Запись #{$item->id} обновлена");

        return redirect(route('admin.'.$this->resourceName.'.index'));
    }
}
