<?php

namespace App\Http\Controllers\Admin;

use App\Card;
use App\CardInfo;
use App\Http\Controllers\BackendController;
use App\Withdrawal;
use Carbon\Carbon;
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
        $this->initializeWithdrawals();

        $this->initializeCards();

        return redirect()->back();
    }

    public function initializeWithdrawals()
    {
        if ( ! request()->hasFile('file_withdrawal')) {
            return;
        }

        if ( ! $this->validateFile(request(), 'file_withdrawal')) {
            return redirect()->back()->withErrors($this->validator);
        }

        $uploadedFile = request()->file('file_withdrawal');

        // Import file to database
        Excel::load($uploadedFile, function ($reader) {
            $reader->noHeading();
            $rows = $reader->skip(1)->toArray();

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

        return true;
    }

    public function initializeCards()
    {
        if ( ! request()->hasFile('file_cards')) {
            return;
        }

        if ( ! $this->validateFile(request(), 'file_cards')) {
            return redirect()->back()->withErrors($this->validator);
        }

        $uploadedFile = request()->file('file_cards');

        // Import file to database
        Excel::load($uploadedFile, function ($reader) {
            $reader->noHeading();
            $rows = $reader->skip(1)->toArray();

            foreach ($rows as $k => $row) {
                $id = $row[1];
                $name = trim($row[2]);
                $last_name = $row[3] === 'NULL' ? '' : trim($row[3]);
                $patronymic = $row[4] === 'NULL' ? '' : trim($row[4]);
                $gender = $row[5] === 'М' ? 1 : ($row[5] === 'Ж' ? 2 : 0);
                $phone = trim($row[6]);
                $birthday_at = $row[7] === 'NULL' ? null : Carbon::parse($row[7]);
                $card_number = $row[8] ?: '';
                $issue_place = empty($row[9]) ? '' : $row[9];
                $type = empty($row[10]) ? '' : $row[10];
                $issued_at = Carbon::parse($row[11]);
                $document_type = $row[12] === 'NULL' ? '' : trim($row[12]);
                $document_number = $row[13] === 'NULL' ? '' : trim($row[13]);
                $document_at = $row[14] === 'NULL' ? null : Carbon::parse($row[14]);
                $document_issued = $row[15] === 'NULL' ? '' : trim($row[15]);
                $car_brand = $row[16] === 'NULL' ? '' : trim($row[16]);
                $car_number = $row[17] === 'NULL' ? '' : trim($row[17]);
                $indate_at = $row[18] === 'NULL' ? null : Carbon::parse($row[18]);

                $card = Card::find($id);

//                if ($card) {
                    $instance = CardInfo::updateOrCreate(['card_id' => $id], [
                        'name' => $name,
                        'last_name' => $last_name,
                        'patronymic' => $patronymic,
                        'gender' => $gender,
                        'phone' => $phone,
                        'birthday_at' => $birthday_at,
                        'card_number' => $card_number,
                        'issue_place' => $issue_place,
                        'type' => $type,
                        'issued_at' => $issued_at,
                        'document_type' => $document_type,
                        'document_number' => $document_number,
                        'document_at' => $document_at,
                        'document_issued' => $document_issued,
                        'car_brand' => $car_brand,
                        'car_number' => $car_number,
                        'indate_at' => $indate_at,
                    ]);
//                }
            }
        });

        // Show success result
        Flash::success('Файл дисконтных карт обработан');

        return true;
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