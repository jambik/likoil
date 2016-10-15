<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Photo;
use Illuminate\Http\Request;

class PhotoableController extends BackendController
{
    /**
     * Save Photo
     *
     * @param Request $request
     * @return Response
     */
    public function savePhoto(Request $request)
    {
        $className = $request->get('model_class');
        $modelId   = $request->get('model_id');

        $model = new $className();

        $item = $model->findOrFail($modelId);

        $photoName = $item->savePhoto($request);

        if($request->ajax()) {
            return response()->json([
                'status'  => 'ok',
                'image'   => $photoName,
                'img_url' => $item->img_url,
                'message' => 'Фотография загружена',
            ]);
        }

        return redirect($request->session()->previousUrl());
    }

    /**
     * Delete Photo
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function deletePhoto($id, Request $request)
    {
        $photo = Photo::findOrFail($id);

        $photo->photoable->deletePhoto($photo);

        if($request->ajax()) {
            return response()->json([
                'status'  => 'ok',
                'message' => 'Фотография удалена',
            ]);
        }

        return redirect($request->session()->previousUrl());
    }
}
