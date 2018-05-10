<?php

namespace App\Http\Controllers;

use App\SphinxClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //商家接口
    public function businessList()
    {
        if (isset($_GET['keyword'])){
            $cl = new SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);
//$cl->SetServer ( '10.6.0.6', 9312);
//$cl->SetServer ( '10.6.0.22', 9312);
//$cl->SetServer ( '10.8.8.2', 9312);
            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
// $cl->SetMatchMode ( SPH_MATCH_ANY);
            $cl->SetMatchMode ( SPH_MATCH_EXTENDED2);
            $cl->SetLimits(0, 1000);
            $info = $_GET['keyword'];
            $res = $cl->Query($info, 'shop');//shop
//print_r($cl);
            if ($res['total']){
                $res = collect($res['matches'])->pluck('id')->toArray();//collect()将数组转化为集合
            }
//            print_r($res);
            $businessLists = DB::table('business_lists')->whereIn('id',$res)->get();
//        dd($businessLists);
            foreach($businessLists as $businessList){
                $businessList->distance=666;
            }
            return $businessLists;
        }
        $businessLists = DB::table('business_lists')->get();
//        dd($businessLists);
        foreach($businessLists as $businessList){
            $businessList->distance=666;
        }
        return $businessLists;
    }

    public function search($keyword)
    {

    }

    public function business(Request $request)
    {

        $business = DB::select("select * from business_lists where id=?",[$request->id]);
        $busi = get_object_vars($business[0]);
//        $food_category = DB::select("select * from food_categories where business_lists_id=?",[$request->id]);
        $food_category = DB::table('food_categories')->where('business_lists_id',$request->id)->get();
        $busi['commodity']=$food_category;
        $busi['evaluate']=[[
            "user_id"=>12344,
            "username"=> "w******k",
            "user_img"=> "http://www.homework.com/images/slider-pic4.jpeg",
            "time"=>"2017-2-22",
            "evaluate_code"=>1,
            "send_time"=>30,
            "evaluate_details"=> "不怎么好吃"
        ],[
            "user_id"=>12344,
            "username"=> "w******k",
            "user_img"=> "http://www.homework.com/images/slider-pic4.jpeg",
            "time"=>"2017-2-22",
            "evaluate_code"=>1,
            "send_time"=>30,
            "evaluate_details"=> "不怎么好吃"
        ]];
//        var_dump($busi);die;

        foreach($food_category as $food_cat){
//                $foods = DB::select("select * from foods where business_lists_id=? and food_categories_id=?",[$request->id,$food_cat->id]);
                $foods = DB::table('foods')->where([['business_lists_id',$request->id],['food_categories_id',$food_cat->id]])->get();
                foreach ($foods as $food){
                    $food->goods_id = $food->id;
                    $food->goods_name = $food->food_name;
                    $food->goods_img = $food->food_image;
                    $food->goods_price = $food->price;
                    $food->month_sales = $food->sales;
                    $food->satisfy_count = $food->satisfy;
                }
            $food_cat->goods_list =$foods;

            }
//        var_dump($busi);die;
//        dd($busi);
        return $busi;
    }
}
