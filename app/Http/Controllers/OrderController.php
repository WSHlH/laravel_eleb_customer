<?php

namespace App\Http\Controllers;

use App\Model\Address;
use App\Model\Carts;
use App\Model\Order;
use App\Model\Order_goods;
use App\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //查看订单列表
        $orders = Order::where('customer_id',Auth::user()->id)->get();
        foreach($orders as $order){
            $order_goods = Order_goods::where('order_id',$order->id)->get();
            $order->goods_list=$order_goods;
            $order->order_address=$order->provence.$order->city.$order->area.$order->detail_address.$order->name.$order->tel;
        }
//        var_dump($order);die;
        return $orders;
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



    public function mail($name,$email)
    {
        Mail::send(
            'mail',//邮件视图模板
            ['name'=>$name],
            function ($message) use($email){
                $message->to($email)->subject('您有新的订单!');
            }
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //生成订单
        $address = Address::find($request->address_id);
        $carts = Carts::where('customer_id',Auth::user()->id)->get();
        $money = 0;
        $order_code = date('Ymd').uniqid();
        foreach($carts as $cart){
            $food = DB::table('foods')->where('id',$cart->goodsList)->first();
            $money += $food->price*$cart->goodsCount;
        }
        $food= DB::table('foods')->where('id',$carts[0]->goodsList)->first();
        $shop = DB::table('business_lists')->where('id',$food->business_lists_id)->first();
//        var_dump($shop);die;
        DB::transaction(function () use($request,$address,$carts,$shop,$money,$order_code){
            $order = Order::create([
                'order_code'=>$order_code,
                'order_birth_time'=>date('Y-m-d H:i:s'),
                'name'=>$address->name,
                'tel'=>$address->tel,
                'provence'=>$address->provence,
                'city'=>$address->city,
                'area'=>$address->area,
                'detail_address'=>$address->detail_address,
                'customer_id'=>Auth::user()->id,
                'shop_id'=>$shop->id,
                'shop_name'=>$shop->shop_name,
                'shop_img'=>$shop->shop_img,
                'order_price'=>$money,
            ]);
            $order_id = $order->id;
            foreach($carts as $cart){
                $food = DB::table('foods')->where('id',$cart->goodsList)->first();
                Order_goods::create([
                    'order_id'=>$order_id,
                    'goods_id'=>$cart->goodsList,
                    'goods_name'=>$food->food_name,
                    'goods_img'=>$food->food_image,
                    'goods_price'=>$food->price,
                    'amount'=>$cart->goodsCount,
                ]);
            }
        });
        $order_id = Order::where('order_code',$order_code)->first()->id;
        //生成订单后,向商家发送邮件
        $tel = DB::table('businesses')->where('id',$shop->id)->first()->phone;
        $this->mail($shop->shop_name,$tel);
        return ["status"=>"true","message"=>"下单成功","order_id"=>$order_id];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request)
    {
//        var_dump($request->id);die;
        //显示订单信息
        $order = Order::where('id',$request->id)->first();
        $order->order_status = $order->order_status==0?'代付款':'已完成';
        $order_goods = Order_goods::where('order_id',$order->id)->get();
        $order->goods_list=$order_goods;
        $order->order_address=$order->provence.$order->city.$order->area.$order->detail_address.$order->name.$order->tel;
        return $order;
    }


    public function pay()
    {
        if (false){
            return [
                "status"=> "false",
                "message"=> "支付失败"
            ];
        }
        /**$order = Order::find($request->id)->update([
        'order_status'=>1,
        ]);*/
        return [
            "status"=> "true",
            "message"=> "支付成功"
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {

    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
