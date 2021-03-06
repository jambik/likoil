<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class AdministratorsController extends BackendController
{
    protected $resourceName = null;

    protected $model = null;

    public function __construct()
    {
        $this->resourceName = 'administrators';
        $this->model = new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = User::whereHas('roles', function ($query) {
            $query->whereNotIn('role_id', [2, 3]);
        })->where('id', '<>', 1)->get();

        return view('admin.'.$this->resourceName.'.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = $this->getRolesList();

        return view('admin.'.$this->resourceName.'.create', compact('roles'));
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
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $item = $this->model->create($request->all());
        $item->password = bcrypt($request->input('password'));
        $item->save();

        $item->roles()->sync($request->get('role') ?: []);

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
        $item->password = '';

        $roles = $this->getRolesList();

        return view('admin.'.$this->resourceName.'.edit', compact('item', 'roles'));
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
        $passwordRule = $request->input('password') ? 'required|min:6' : '';

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'password' => $passwordRule
        ]);

        $item = $this->model->findOrFail($id);

        $item->roles()->sync($request->get('role'));

        $item->update($request->except('password') +
            ($passwordRule ? ['password' => bcrypt($request->input('password'))] : []));

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

    /**
     * Get Roles list
     *
     * @return mixed
     */
    private function getRolesList()
    {
        return Role::whereNotIn('id', [2, 3])->get()->pluck('display_name', 'id');
    }

}
