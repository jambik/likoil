<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use App\Http\Controllers\BackendController;

class FeedbacksController extends BackendController
{
    protected $resourceName = null;

    protected $model = null;

    public function __construct()
    {
        $this->resourceName = 'feedbacks';
        $this->model = new Feedback();
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
