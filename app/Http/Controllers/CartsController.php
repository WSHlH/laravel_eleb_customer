<?php

namespace App\Http\Controllers;

use App\Model\Carts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ///php artisan make:model Model\
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('carts')->where('customer_id',Auth::user()->id)->delete();
        foreach($request->goodsList as $key=>$goods_id){
            Carts::create([
                'goodsList'=>$goods_id,
                'goodsCount'=>$request->goodsCount[$key],
                'customer_id'=>Auth::user()->id,
            ]);
        }
       return ['status'=>'true','message'=>'购物车添加成功'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $cart = DB::table('carts')->where('customer_id',Auth::user()->id)->get();
        $foods = [];
        foreach($cart as $item){
            $food = DB::table('foods')->where('id',$item->goodsList)->first();
            $food->goods_id = $food->id;
            $food->amount = $item->goodsCount;
            $food->goods_name = $food->food_name;
            $food->goods_price = $food->price;
            $foods[] = $food;
        }
        $order['goods_list'] = $foods;
        $money = 0;
//        var_dump($order['goods_list'][0]->amount*$order['goods_list'][0]->goods_price);die;
        foreach($order['goods_list'] as $v){
            $money += $v->amount*$v->goods_price;
        }
        $order['totalCost'] = $money;
//        var_dump($money);die;
        return $order;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function edit(Carts $carts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carts $carts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Carts  $carts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carts $carts)
    {
        //
    }
}
