<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use App\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    function sendSms(Request $request) {

        $params = array ();

        // *** 需用户填写部分 ***

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = "LTAIxNo7qxbpUsqV";
        $accessKeySecret = "Ye4O7Cdo3xsQw6HktDl2BPZrdkE3Jk";

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $request->tel;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = "我们的店";

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = "SMS_133760022";

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array (
            "code" => mt_rand(100000,999999),
            //"product" => "阿里通信"
        );
        //将验证码存入redis
        $sms = Redis::setex('code'.$request->tel,600,$params['TemplateParam']['code']);
//        $code = Redis::get('code');
//        dd($code);

        // fixme 可选: 设置发送短信流水号
        //$params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new Sms();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        // fixme 选填: 启用https
        // ,true
        );

//        dd($content);
        if ($content->Message=='OK'){
            //发送成功
            return ["status"=>"true","message"=>"获取短信验证码成功"];
        }else{
            //发送失败
            return ["status"=>"true","message"=>"短信获取失败"];
        }
    }

    public function regist(Request $request)
    {
//        return $request->input();
        $redis = Redis::get('code'.$request->tel);
        if ($redis==$request->sms){
            //验证

            $validator = Validator::make($request->all(), [
                'username'=>'required|max:10|unique:customers',
                'password'=>'required|max:16|min:3',
                'tel'=>'required|unique:customers|regex:/^1[3458][0-9]\d{4,8}$/',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                return ['status'=>'false','message'=>$errors];
            }

            Customer::create([
                'username'=>$request->username,
                'password'=>bcrypt($request->password),
                'tel'=>$request->tel,
            ]);
            return ["status"=>"true","message"=>"注册成功"];
        }
else{
            return ["status"=>"false","message"=>"验证码错误,注册失败!"];
        }
    }



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
    public function create(Request $request)
    {
//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //登录验证
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:10',
            'password' => 'required|max:16|min:3',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            return ['status'=>'false','message'=>$errors];
        }

        if (Auth::attempt(['username'=>$request->name,'password'=>$request->password],true)){
            //登录成功
            return ["status"=>"true","message"=>"登录成功",
                "user_id"=>Auth::user()->id,"username"=>Auth::user()->username];
        }else{
//            return $request->input();
            return ["status"=>"false","message"=>"用户名或密码错误,登录失败"];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
