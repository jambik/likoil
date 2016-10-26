<?php

namespace App\Http\Controllers\Admin;

use App\Card;
use App\Http\Controllers\BackendController;
use DB;
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
//                $query->orWhere('name', 'LIKE', '%'.$search['value'].'%');
                $recordsFiltered = $query->count();
            }

            // Добавление пагинации
            $query->skip($start)->limit($length);

            // Добавление сортировки по колонкам
            foreach ($order as $orderColumn) {
                if ( ! in_array($columns[$orderColumn['column']]['data'], ['bonus'])) { // Если поле бонус то пропускаем
                    $query->orderBy($columns[$orderColumn['column']]['data'], $orderColumn['dir']);
                }
            }

            $items = $query->get();

            // Добавление сортировки по колонкам
            foreach ($order as $orderColumn) {
                if (in_array($columns[$orderColumn['column']]['data'], ['bonus'])) { // Если поле бонус то пропускаем
                    if ($orderColumn['dir'] == 'desc') {
                        $items = $items->sortByDesc('bonus')->values();
                    } else {
                        $items = $items->sortBy('bonus')->values();
                    }
                }
            }

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
            'Code' => 'required|unique',
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
            'Code' => 'required|unique:' . $this->model->getTable() . ',Code,'.$id,
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
        /*$this->validate($request, [
            'info.name' => 'required',
        ]);*/

        $item = $this->model->findOrFail($id);

        $data = $request->get('info');

        foreach (['birthday_at', 'issued_at', 'document_at'] as $value) $data[$value] = $data[$value] ?: null;

//        dd($data);

        if ($item->info()->count()) {
            $item->info()->update($data);
        } else {
            $item->info()->create($data);
        }

        Flash::success("Запись #{$item->id} обновлена");

        return redirect(route('admin.'.$this->resourceName.'.index'));
    }
}
