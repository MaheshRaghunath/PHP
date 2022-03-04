<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ChartController extends Controller
{
    public function pieChart() 
    {
        $result = DB::select(DB::raw("select c.applicable_for,c.Item,c.Value,d.value from glide_db.calorific c left join glide_db.data d ON c.id = d.id" ));
        return view('calorific.piechart');
    }
}
