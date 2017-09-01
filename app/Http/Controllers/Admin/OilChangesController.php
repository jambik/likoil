<?php

namespace App\Http\Controllers\Admin;

use App\Card;
use App\Http\Controllers\BackendController;
use App\OilChange;
use Illuminate\Http\Request;

class OilChangesController extends BackendController
{
    protected $resourceName = null;

    protected $model = null;

    public function __construct()
    {
        $this->resourceName = 'oil_changes';
        $this->model = new OilChange();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $card  = $request->exists('card') ? Card::findOrFail($request->get('card')) : false;
        $items = $card ? $this->model->where('card_id', $request->get('card'))->with('card')->get() : $this->model->with('card')->get();

        return view('admin.'.$this->resourceName.'.index', compact('items', 'card'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $card  = Card::findOrFail($request->get('card'));

        return view('admin.'.$this->resourceName.'.create', compact('card'));
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
            'card' => 'required|numeric',
            'mileage' => 'required|numeric',
            'change_at' => 'date',
        ]);

        $data = [
            'card_id' => $request->get('card'),
            'mileage' => $request->get('mileage'),
            'change_at' => $request->exists('change_at') && $request->get('change_at') ? $request->get('change_at') : date('Y-m-d'),
        ];

        $this->model->create($data);

        return redirect(route('admin.'.$this->resourceName.'.index', ['card' => $request->get('card')]));
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
     * @param  int $id
     * @param Request $request
     * @return Response
     */
    public function edit($id, Request $request)
    {
        $card  = Card::findOrFail($request->get('card'));
        $item = $this->model->findOrFail($id);

        return view('admin.'.$this->resourceName.'.edit', compact('item', 'card'));
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

        return redirect(route('admin.'.$this->resourceName.'.index', ['card' => $request->get('card')]));
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
