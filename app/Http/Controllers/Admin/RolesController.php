<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RolesController extends BackendController
{
    protected $resourceName = null;
    protected $model = null;

    public function __construct()
    {
        $this->resourceName = 'roles';
        $this->model = new Role();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = $this->model->whereNotIn('id', [1, 2, 3])->get();

        return view('admin.'.$this->resourceName.'.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $permissions = $this->getPermissionsList();

        return view('admin.'.$this->resourceName.'.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
        ]);

        $item = $this->model->create($request->all());

        $item->perms()->sync($request->get('permissions_ids') ?: []);

        return redirect(route('admin.'.$this->resourceName.'.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return $this->model->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $item = $this->model->findOrFail($id);

        $permissions = $this->getPermissionsList();

        return view('admin.'.$this->resourceName.'.edit', compact('item', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            'display_name' => 'required',
        ]);

        $item = $this->model->findOrFail($id);

        $item->update($request->all());

        $item->perms()->sync($request->get('permissions_ids') ?: []);

        return redirect(route('admin.'.$this->resourceName.'.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->model->destroy($id);

        return redirect(route('admin.'.$this->resourceName.'.index'));
    }

    private function getPermissionsList()
    {
        $permissions = Permission::all();

        $permissions = $permissions->map(function ($item, $key) {
            $item['full_name'] = $item['name'] . ' (' . $item['display_name'] . ')';
            return $item;
        });

        $permissions = $permissions->pluck('full_name', 'id');

        return $permissions;
    }

}
