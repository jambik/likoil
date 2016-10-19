<?php

namespace App\Http\Controllers\Admin;

use App\Card;
use App\Http\Controllers\BackendController;
use App\Withdrawal;
use Flash;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class InitializationController extends BackendController
{
    protected $validator;

    public function index()
    {
        return view('admin.initialization.index');
    }

    public function save(Request $request)
    {
        if ($request->hasFile('file_withdrawal') && !$this->validateFile($request, 'file_withdrawal')) {
            return redirect()->back()->withErrors($this->validator);
        }

        $uploadedFile = $request->file('file_withdrawal');

        // Import file to database
        Excel::load($uploadedFile, function ($reader) {
            $reader->noHeading();
            $rows = $reader->skip(1)->toArray();

//            dd($rows);

            foreach ($rows as $k => $row) {
                $type = $row[2];
                $code = $row[3];
                $amount = $row[4];
                $date = $row[5];
                $azs = $row[6];

                $card = Card::where('code', $code)->first();

                if ($card) {
                    Withdrawal::create([
                        'card_id' => $card->id,
                        'amount' => $amount,
                        'type' => $type,
                        'azs' => $azs,
                        'use_at' => Str::substr($date, 0, 19),
                    ]);
                }
            }
        }, 'cp1251');

        // Show success result
        Flash::success('Файл расходов обработан');
        return redirect()->back();
    }

    public function validateFile(Request $request, $fileName = 'file')
    {
        // Validation rules
        $this->validator = Validator::make($request->all(), [
            $fileName => 'required',
        ]);

        // Get file
        $file = $request->file($fileName);

        // Additional validation rules
        $this->validator->after(function() use ($file, $fileName) {
            if ($file && $file->getClientOriginalExtension() !== 'csv') {
                $this->validator->errors()->add($fileName, 'Неверное расширение файла - допускается только файлы с расширением .csv');
            }

            if ($file && $file->getClientMimeType() !== 'application/vnd.ms-excel') {
                $this->validator->errors()->add($fileName, 'Неверный формат файла - допускается только файл формата CSV разделитель - ;');
            }
        });

        // Check if validation fails
        if ($this->validator->fails()) {
            return false;
        }

        return true;
    }
}