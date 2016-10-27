<?php

namespace App\Http\Controllers\Admin;

use App\Campaign;
use App\Http\Controllers\BackendController;
use App\Rate;
use App\User;
use Illuminate\Http\Request;

class CampaignsController extends BackendController
{
    protected $resourceName = null;
    protected $model = null;

    public function __construct()
    {
        $this->resourceName = 'campaigns';
        $this->model = new Campaign();
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
        $azs = $this->getAzsList();
        $fuels = $this->getFuelsList();

        return view('admin.'.$this->resourceName.'.create', compact('azs', 'fuels'));
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
            'start_at' => 'required|date',
            'end_at' => 'required|date',
            'rate' => 'required|numeric',
            'time_start' => 'required_with:time_end',
            'time_end' => 'required_with:time_start',
        ]);

        $input = $request->all();

        foreach (['time_start', 'time_end'] as $value) $input[$value] = $input[$value] ?: 0;

        $item = $this->model->create($input);

        $item->azs()->sync($request->get('azs_ids') ?: []);
        $item->fuels()->sync($request->get('fuels_ids') ?: []);

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

        $azs = $this->getAzsList();
        $fuels = $this->getFuelsList();

        return view('admin.'.$this->resourceName.'.edit', compact('item', 'azs', 'fuels'));
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
            'start_at' => 'required|date',
            'end_at' => 'required|date',
            'rate' => 'required|numeric',
            'time_start' => 'required_with:time_end',
            'time_end' => 'required_with:time_start',
        ]);

        $item = $this->model->findOrFail($id);

        $input = $request->all();

        foreach (['days'] as $value) $input[$value] = $request->has($value) ? $request->get($value) : '';

        $item->update($input);

        $item->azs()->sync($request->get('azs_ids') ?: []);
        $item->fuels()->sync($request->get('fuels_ids') ?: []);

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

    private function getAzsList()
    {
        $azs = User::whereHas('roles', function ($query) {
            $query->where('role_id', 3);
        })->get();

        return $azs->pluck('name', 'id');
    }

    private function getFuelsList()
    {
        $fuels = Rate::all();

        return $fuels->pluck('name', 'id');
    }
}
