<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Withdrawal;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class WithdrawalsController extends BackendController
{
    protected $resourceName = null;

    protected $model = null;

    public function __construct()
    {
        $this->resourceName = 'withdrawals';
        $this->model = new Withdrawal();
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

            $query = DB::table('withdrawals')
                ->leftJoin('cards', 'withdrawals.card_id', '=', 'cards.id')
                ->select('withdrawals.*', 'cards.code');

            // Фильтр по дате
            if ($request->has('daterange')) {
                $daterange = $request->get('daterange');
                $dateStart = str_replace('.', '-', substr($daterange, 0, strpos($daterange, '-') - 1) . ' 00:00:00');
                $dateEnd = str_replace('.', '-', substr($daterange, strpos($daterange, '-') + 2) . ' 23:59:59');

                $query->where('use_at', '>=', $dateStart);
                $query->where('use_at', '<=', $dateEnd);
            }

            // Поиск
            if ($search['value']) {
                $query->where(function ($query) use ($search) {
                    $query->where('code', 'LIKE', '%'.$search['value'].'%')->orWhere('azs', 'LIKE', '%'.$search['value'].'%');
                });
            }

            // Получить количество фильтрованных записей
            if ($search['value'] || $request->has('daterange')) {
                $recordsFiltered = $query->count();
            }

            // Добавление пагинации
            $query->skip($start)->limit($length);

            // Добавление сортировки по колонкам
            foreach ($order as $orderColumn) {
                $query->orderBy($columns[$orderColumn['column']]['data'], $orderColumn['dir']);
            }

            $items = $query->get();

            $items->transform(function ($item, $key) {
                $item->use_at = Carbon::parse($item->use_at)->setTimezone('Europe/Moscow')->format('d.m.Y H:i');
                return $item;
            });

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $items,
            ]);
        }

//        $items = $this->model->all();

        return view('admin.'.$this->resourceName.'.index', compact('items'));
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
        $this->model->create($request->all());

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
        $item = $this->model->findOrFail($id);

        return view('admin.'.$this->resourceName.'.show', compact('item'));
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
        $item = $this->model->findOrFail($id);

        $item->update($request->all());

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
}
