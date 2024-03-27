<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use DB;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('users')->select('id','name','email','permission_id','perm_name','dept_name')
                ->join('acc_permission','perm_id','permission_id')
                ->join('acc_department','dept_id','department')
                ->get();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $hash = Hash::make(12345);
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->username,
            'password' => $hash,
            'department' => $request->department,
            'permission_id' => $request->permission,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('users')->select('id','name','email','permission_id','perm_name')
                ->join('acc_permission','perm_id','permission_id')
                ->where('id',$id)
                ->first();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
