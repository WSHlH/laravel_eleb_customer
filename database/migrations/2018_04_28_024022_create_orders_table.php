<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code')->unique();
            $table->timestamp('order_birth_time');
            $table->unsignedTinyInteger('order_status');
            $table->unsignedInteger('shop_id');
            $table->string('shop_name');
            $table->string('shop_img');
            $table->string('name');
            $table->string('tel');
            $table->string('provence');
            $table->string('city');
            $table->string('area');
            $table->string('detail_address');
            $table->timestamps();
            $table->engine='InnoDB';
        });
    }
    /**
     *  * name: 收货人
     * tel: 联系方式
     * provence: 省
     * city: 市
     * area: 区
     * detail_address: 详细地址
     *  * "order_code": 订单号
     * "order_birth_time": 订单创建日期
     * "order_status": 订单状态
     * "shop_id": 商家id
     * "shop_name": 商家名字
     * "shop_img": 商家图片
     * "goods_list": [{//购买商品列表
     * "goods_id": "1"//
     * "goods_name": "汉堡"
     * "goods_img": "http://www.homework.com/images/slider-pic2.jpeg"
     * "amount": 6
     * "goods_price": 10
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
