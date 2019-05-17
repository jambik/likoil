<?php

namespace App\Http\Controllers\Admin;

use App\Card;
use App\Http\Controllers\BackendController;
use App\Bonus;
use Auth;
use Illuminate\Http\Request;

class BonusController extends BackendController
{
    protected $resourceName = null;

    protected $model = null;

    public function __construct()
    {
        $this->resourceName = 'bonus';
        $this->model = new Bonus();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = $this->model->orderBy('created_at', 'desc')->get();

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
            'card' => 'required',
            'amount' => 'required|integer',
        ]);

        $card = Card::where('code', $request->get('card'))->first();

        if (! $card) {
            return redirect(route('admin.'.$this->resourceName.'.index'))
                ->withErrors("Карта с номером #{$request->get('card')} не найдена");
        }

        $input = $request->all();
        $input['card_id'] = $card->id;
        $input['user_id'] = Auth::id();

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

        $item['card'] = $item->card->code;

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
            'card' => 'required',
            'amount' => 'required|integer',
        ]);

        $item = $this->model->findOrFail($id);

        $card = Card::where('code', $request->get('card'))->first();

        if (! $card) {
            return redirect(route('admin.'.$this->resourceName.'.index'))
                ->withErrors("Карта с номером #{$request->get('card')} не найдена");
        }

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
        $item = $this->model->findOrFail($id);

        $item->delete();

        return redirect(route('admin.'.$this->resourceName.'.index'));
    }
}
