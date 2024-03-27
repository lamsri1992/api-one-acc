<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class listController extends Controller
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
                LEFT JOIN acc_status ON acc_status.status_id = acc_list.list_status");
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date = date("Y-m-d");
        $datein = date("Y-m-d",strtotime($request->datein));
        $hash = date("Ymdhiss").Str::random(40);

        
        DB::table('acc_list')->insert([
            'list_hash'=>$hash,
            'list_year'=>$request->year,
            'list_date_in'=>$datein,
            'list_doc_no'=>$request->docno,
            'list_acc_type'=>$request->acctype,
            'list_acc_sub'=>$request->subtype,
            'list_creditor'=>$request->creditor,
            'list_note'=>$request->note,
            'list_doc_item'=>$request->docitem,
            'list_total'=>$request->total,
            'list_datedue'=>$request->datedue,
            'list_create_date'=>$date,
            'list_creator'=>$request->creator,
            'list_department'=>$request->department,
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
                LEFT JOIN acc_department ON acc_department.dept_id = acc_list.list_department
                LEFT JOIN users ON users.id = acc_list.list_creator
                LEFT JOIN acc_status ON acc_status.status_id = acc_list.list_status
                WHERE acc_list.list_hash = '{$id}' ");
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $datein = date("Y-m-d",strtotime($request->datein));
        $total = str_replace(",","",$request->total);

        DB::table('acc_list')->where('list_id',$id)->update([
            'list_year'=>$request->year,
            'list_date_in'=>$datein,
            'list_doc_no'=>$request->docno,
            'list_acc_type'=>$request->acctype,
            'list_acc_sub'=>$request->subtype,
            'list_creditor'=>$request->creditor,
            'list_note'=>$request->note,
            'list_doc_item'=>$request->docitem,
            'list_total'=>$total,
            'list_datedue'=>$request->datedue,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
