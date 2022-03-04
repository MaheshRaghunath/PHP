<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calorific;
use Illuminate\Support\Facades\DB;
use App\Data;

class CalorificController extends Controller
{
    public function index() 
    {
        
        $returnData = DB::table('calorific')
        ->select('calorific.id','calorific.applicable_for','calorific.Item','data.value')
        ->leftJoin('data','calorific.id','data.id')
        ->get();

        $chart = '';
        if ($returnData) {
            $chartData = '';
            foreach ($returnData as $keyVal) {
                $chartData .= "[ '". $keyVal->Item ."', " . $keyVal->value . "],";
            }
            $chart = $chartData ?? '';
        }
        
        
        return view('calorific.glide',[
            'data' =>  $returnData,
            'chart' => $chart
        ]);

    }
    public function edit($id) 
    {
        // $editData = Calorific::find($id);
        $editData = DB::table('calorific')
        ->select('calorific.id','calorific.applicable_for','calorific.Item','data.value')
        ->leftJoin('data','calorific.id','data.id')
        ->where('calorific.id','=',$id)
        ->get()->first();
        //dd($editData);
        return view('calorific.edit',['editData' => $editData]);
    }
    public function Add() 
    {
        // error_log(request('id'));
        $calorificObj = new Calorific();
        $calorificObj->applicable_for = request('applicable');
        $calorificObj->Item = request('area');
        $calorificObj->created_at = date("Y-m-d H:i:s", strtotime('now'));
        $calorificObj->updated_at = date("Y-m-d H:i:s", strtotime('now'));

        $calorificObj->save();
        return redirect('/')->with('message', 'Data has been saved!');
    }
    public function saveData($id) 
    {

        $dataExist = Calorific::find($id);

        $dataExist->applicable_for = request('applicable');
        $dataExist->Item = request('area');
        $dataExist->created_at = date("Y-m-d H:i:s", strtotime('now'));
        $dataExist->updated_at = date("Y-m-d H:i:s", strtotime('now'));
        $dataExist->save();
        //dd($dataExist->id);
        if ($dataExist->id) {
            $dataTable = Data::findOrFail($dataExist->id);
            $dataTable->value = request('values');
            $dataTable->created_at = date("Y-m-d H:i:s", strtotime('now'));
            $dataTable->updated_at = date("Y-m-d H:i:s", strtotime('now'));
            $dataTable->save();
        }

        return redirect('/')->with('message', 'Data has been saved!');
    }
    public function distroy($id) 
    {
        $deleteData = Calorific::findOrFail($id);
        $deleteData->delete();
        return redirect('/')->with('message', 'Data has been Deleted!');
    }
    public function search() 
    {
        $search = request('param') ?? '';
        //error_log($search);
        if (!$search) {
            return redirect('/')->with('message', 'Search is empty!!');
        }
        
        if ($search) {
            $search = "%". urldecode($search) . "%";
        }
        
        // $returnData = Calorific::where('Item','LIKE', $search)->get();
        $returnData = DB::table('calorific')
        ->select('calorific.id','calorific.applicable_for','calorific.Item','data.value')
        ->join('data','calorific.id','data.id')
        ->where('calorific.Item','LIKE',$search)
        ->get();
        
        if (!sizeof($returnData)) {
            //$returnData = Calorific::where('applicable_for','LIKE',$search)->get();
            $returnData = DB::table('calorific')
            ->select('calorific.id','calorific.applicable_for','calorific.Item','data.value')
            ->join('data','calorific.id','data.id')
            ->where('calorific.applicable_for','LIKE',$search)
            ->get();
        }

        if (!sizeof($returnData)) {
            //$returnData = Data::where('value','LIKE',$search)->get();
            $returnData = DB::table('data')
            ->select('calorific.id','calorific.applicable_for','calorific.Item','data.value')
            ->join('calorific','data.id','calorific.id')
            ->where('data.value','LIKE',$search)
            ->get();
        }
        
        
        $chart = '';
        if ($returnData) {
            $chartData = '';
            foreach ($returnData as $keyVal) {
                $chartData .= "[ '". $keyVal->Item ."', " . $keyVal->value . "],";
            }
            $chart = $chartData ?? '';
        }
        
       // dd($chart );
        return view('calorific.glide',[
            'data' =>  $returnData,
            'chart' => $chart
        ]);
    }

    public function parseAllFromCsv() 
    {
        $filename = public_path('file/DataItem.csv');
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }
        $delimiter = ',';
        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine( str_replace(' ', '', $header), $row);
            }
            fclose($handle);
        }
        
        //$table2 = new Data;

        foreach ($data as $value) {
            $table1 = new Calorific;
            $table1->applicable_for = $value['ApplicableFor'];
            $table1->Item = $value['DataItem'];
            $table1->save();
            if ($table1->id) {
                DB::table('data')->insert(array(
                    'id' => $table1->id,
                    'value' => $value['Value'],
                    'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now'))
                ));
            
             }
        }
        
        return redirect('/')->with('message', 'Data has been saved!');
    }
}
