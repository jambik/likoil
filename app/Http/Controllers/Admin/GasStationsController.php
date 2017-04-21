<?php

namespace App\Http\Controllers\Admin;

use App\GasStation;
use App\Http\Controllers\BackendController;
use Conner\Tagging\Model\Tag;
use Illuminate\Http\Request;

class GasStationsController extends BackendController
{
    protected $resourceName = null;

    protected $model = null;

    public function __construct()
    {
        $this->resourceName = 'gas_stations';
        $this->model = new GasStation();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = $this->model->all();

        return view('admin.'.$this->resourceName.'.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
//        $tags_service = Tag::inGroup('services')->pluck('name');
//        $tags_fuel    = Tag::inGroup('fuel')->pluck('name');

        return view('admin.'.$this->resourceName.'.create', compact('tags_service', 'tags_fuel'));
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
            'name' => 'required',
        ]);

        $item = $this->model->create($request->all());

//        $request->tags_service ? $item->tag(explode(',', $request->tags_service)) : null;
//        dd($item->existingTags());

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
//        $tags_service = Tag::inGroup('services')->pluck('name');
//        $tags_fuel    = Tag::inGroup('fuel')->pluck('name');

        return view('admin.'.$this->resourceName.'.edit', compact('item', 'tags_service', 'tags_fuel'));
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
            'name' => 'required',
        ]);

        $item = $this->model->findOrFail($id);

        $item->update($request->all());

//        $request->tags_service ? $item->tag(explode(',', $request->tags_service)) : $item->untag();
//        dd($request->get('tags_service'));
//        dd($item->tags->toArray());

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
