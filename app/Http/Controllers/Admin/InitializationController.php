<?php

namespace App\Http\Controllers\Admin;

use App\Card;
use App\CardInfo;
use App\Discount;
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
//        $list1 = '3238,14838,16508,16628,17895,22342,38094,40576,41101,41650,42659,48891,49472,50265,62117,63920,69466,70162,72192,74303,78327,79186,87095,87438,87641,87953,88258,88785,88798,88860,88927,88976,89506,89952,89975,90083,90967,92752,93042,93488,93553,95072,95369,95382,95726,95890,96334,96505,96673,96912,97090,97677,97800,98048,99265,99498,99878,99983,100643,100957,101480,101588,101766,101880,101902,101960,101988,101996,102825,103505,104025,104300,104466,104527,104766,104818,104931,105426,105580,105667,106586,106666,106668,106899,108228,108288,108495,108596,108715,108800,109033,109108,109858,109961,110002,110123,110527,110704,111041,111226,111462,111642,112337,113093,114115,115154,115635,115733,115747,116031,116956,117033,117078,117296,117599,117897,118033,118477,118560,118657,119182,119500,119615,119680,119998,120946,121390,121974,123124,123572,123773,123968,124728,125150,125986,127188,127272,127340,127357,127426,128567,129193,129356,129563,130295,130531,131174,131195,132047,132233,132533,133277,134097,134173,134234,134317,134843,135331,135678,135801,135992,136293,137283,137339,137392,138337,139363,139562,140687,140799,141065,141493,142977,143892,144000,144167,144232,144622,144723,145623,145781,146992,147848,149397,149551,150471,150485,150516,151686,152056,152059,152487,152538,152831,153182,154042,154823,154877,155391,156134,156793,156806,157107,157161,157164,158275,160290,160300,160317,160449,160608,162033,162053,162451,162879,163021,163958,164701,164741,165047,165472,165921,166017,166030,166052,166076,166200,166324,166344,166394,166414,167269,167442,167929,168390,168458,168508,168601,169312,169473,169780,170170,170384,170652,170866,170934,171282,171283,171411,171772,172068,172084,172143,172457,172507,172567,172737,173719,174095,174101,174154,174689,174786,175357,175415,175748,175970,176063,177348,177525,177762,178092,178124,178502,178716,178860,178874,179008,179263,179283,179442,179517,179817,179868,179979,180026,180073,180349,180547,180571,180699,180980,181028,181419,181535,181647,181816,181942,181945,182349,182422,182426,182500,182567,183137,184257,184802,185089,185394,185431,185740,185855,186439,186572,186967,187014,187186,187202,187925,187933,188028,188055,188097,188102,188200,188275,188460,188606,188854,188974,189190,189271,189294,189431,189454,189591,189599,189603,189617,189701,189728,189782,190041,190066,190108,190122,190137,190170,190174,190254,190256,190453,190527,190679,190712,190747,190767,190804,191017,191053,191151,191245';
//        $list2 = '38148,38598,41730,62380,69610,74008,75308,79763,80465,87984,88930,89032,91133,91680,91854,92702,93091,95381,97050,97315,98255,98551,98999,99781,99961,99971,100017,100024,101520,101640,102310,103184,103544,104489,104620,104840,105973,109599,109967,110137,111593,111598,111845,112789,114571,115774,116565,116593,116862,116869,117868,118877,119619,119643,119670,119700,119726,119866,120017,120292,121738,122173,124414,124963,126054,127765,129065,130700,132421,133867,134055,134451,135622,136111,141287,143994,144610,146589,147399,148374,149189,149354,150140,150900,152020,152785,153496,154834,155369,159548,162383,163642,163652,166003,166343,166650,168770,168983,169017,169868,170613,171249,171250,171310,171341,172187,172405,172437,173145,173314,173488,173574,175200,175393,175513,175552,176171,176838,177576,178278,178378,178472,178550,178780,179028,179269,179336,179403,180373,181099,181175,181228,181263,181391,181446,181513,181520,181822,182288,183722,184341,184838,185837,186492,186772,186779,186942,187750,187765,187784,187813,187932,187942,188108,188872,188873,189035,189218,189751,189949,190103,190155,190236,191208';
//        $list3 = '109234';
//
//        $listArray = explode(',', $list3);
//
//        $i = 2000;
//        foreach ($listArray as $val) {
//            $item = Discount::updateOrCreate([
//                'id' => $i,
//                'card_id' => $val,
//                'date' => Carbon::now(),
//                'azs' => 'bonus',
//                'amount' => 0,
//                'volume' => 0,
//                'price' => 0,
//                'fuel_name' => 'ГАЗ',
//                'point' => 550,
//                'rate' => 0,
//                'start_at' => Carbon::now(),
//            ]);
//
//            $i++;
//
//            dump($item);
//        }

//        SELECT card_id, COUNT(id) as discounts_count, SUM(volume) AS discounts_sum
//FROM (
//    SELECT card_id
//    FROM discounts
//    WHERE date > '2019-02-01 00:00:00' AND date < '2019-02-28 23:59:59' AND (fuel_name = 'ГАЗ' OR fuel_name = 'кГАЗ')
//    ) AS d
//GROUP BY card_id
//HAVING discounts_sum > 349

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

                if ($card) {
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
                }
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