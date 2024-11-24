<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\IncomeListNetProfit;
use App\Http\Controllers\Controller;

class NetProfitController extends Controller
{

    public function index(Request $request)
    {
        $netProfits = IncomeListNetProfit::where(function ($query) use($request) {
            if ($request->branch_id != null) {
                $query->where('branch_id', $request->branch_id);
            }
            if ($request->start_date != null && $request->end_date != null) {
                $query->where('start_date', $request->start_date)->$query->where('end_date', $request->end_date);
            }
        })->paginate(config('constants.paginationNo'));
        return view('admin.pages.net_profit.index');
    }
}
