<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class listFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::select("SELECT * , DATE_ADD(list_date_in, INTERVAL list_datedue DAY) AS limit_date 
                FROM acc_list 
                LEFT JOIN acc_type ON acc_type.type_id = acc_list.list_acc_type 
                LEFT JOIN acc_sub_type ON acc_sub_type.sub_id = acc_list.list_acc_sub 
                LEFT JOIN acc_creditor ON acc_creditor.creditor_id = acc_list.list_creditor 
                LEFT JOIN acc_status ON acc_status.status_id = acc_list.list_status
                WHERE acc_list.list_status = '2'");
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date = date("Y-m-d");
        $datePaid = date("Y-m-d",strtotime($request->datePaid));

        DB::table('acc_finance')->insert([
            "fin_bill" => $request->billNo,
            "fin_paid_date" => $datePaid,
            "fin_paid_total" => $request->paidCash,
            "fin_check_number" => $request->checkNo,
            "fin_budget_type" => $request->typePaid,
            "list_id" => $request->listHash,
            "fin_creator" => $request->creator,
            "fin_created_date" => $date,
        ]);

        DB::table('acc_list')->where('list_hash',$request->listHash)->update([
            "list_status" => 3,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::select("SELECT * , DATE_ADD(list_date_in, INTERVAL list_datedue DAY) AS limit_date 
                FROM acc_list 
                LEFT JOIN acc_type ON acc_type.type_id = acc_list.list_acc_type 
                LEFT JOIN acc_sub_type ON acc_sub_type.sub_id = acc_list.list_acc_sub 
                LEFT JOIN acc_creditor ON acc_creditor.creditor_id = acc_list.list_creditor 
                LEFT JOIN acc_status ON acc_status.status_id = acc_list.list_status
                LEFT JOIN acc_finance ON acc_finance.list_id = acc_list.list_hash
                LEFT JOIN acc_budget ON acc_budget.bud_id = acc_finance.fin_budget_type
                LEFT JOIN users ON users.id = acc_finance.fin_creator
                WHERE acc_list.list_hash = '{$id}' ");
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
