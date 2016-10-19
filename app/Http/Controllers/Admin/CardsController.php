<?php

namespace App\Http\Controllers\Admin;

use App\Card;
use App\Http\Controllers\BackendController;
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
     * @return Response
     */
    public function index()
    {
        $items = $this->model->with('discounts', 'withdrawals')->limit(100)->get();

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
        //
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
}
