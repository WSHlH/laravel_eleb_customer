<?php

namespace App\Http\Controllers;

use App\Model\address;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

    }

    public function addressList()
    {
        $addresses = DB::table('addresses')->where('customers_id','=',Auth::user()->id)->get();
        return $addresses;

    }

    public function addAddress(Request $request)
    {
//        dd($request);
//        return $request->input();
        //验证
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(),[
            "name"=>"required|max:10",
            "tel"=>"required|regex:/^1[3458][0-9]\d{8}$/",
            "provence"=>"required",
            "city"=>"required",
            "area"=>"required",
            "detail_address"=>"required",
        ]);
        if ($validator->fails()){
            $error = $validator->errors()->first();
            return $error;
        }
        Address::create([
            'name'=>$request->name,
            'tel'=>$request->tel,
            'provence'=>$request->provence,
            'city'=>$request->city,
            'area'=>$request->area,
            'detail_address'=>$request->detail_address,
            'customers_id'=>Auth::user()->id,
        ]);
        return ['status'=>'true','message'=>'添加成功'];
    }

    public function address(Request $request)
    {
        $address = Address::find($request->id);
        return response()->json($address);
    }

    public function editAddress(Request $request)
    {
        //验证
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(),[
            "name"=>"required|max:10",
            "tel"=>"required|regex:/^1[3458][0-9]\d{8}$/",
            "provence"=>"required",
            "city"=>"required",
            "area"=>"required",
            "detail_address"=>"required",
        ]);
        if ($validator->fails()){
            $error = $validator->errors()->first();
            return $error;
        }
        DB::table('addresses')->where('id',$request->id)->update([
            'name'=>$request->name,
            'tel'=>$request->tel,
            'provence'=>$request->provence,
            'city'=>$request->city,
            'area'=>$request->area,
            'detail_address'=>$request->detail_address,
        ]);
        return ['status'=>'true','message'=>'修改成功'];
    }

    public function addressDelete(Request $request)
    {
        $address = DB::table('addresses')->whereCart('id',$request->id)->delete();
        return ['status'=>'true','message'=>'删除成功'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(address $address)
    {
        //
    }
}
