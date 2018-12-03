<?php
namespace app\api\controller;

class Index
{
    public function index()
    {
        return 'api';
    }
    public function jsondata()
    {
        $data = ['name'=>'thinkphp','url'=>'iamcaojie.com'];
        return json(['data'=>$data,'code'=>'code','message'=>'Done']);
    }
    public function xmldata()
    {
        $data = ['name'=>'thinkphp','url'=>'iamcaojie.com'];
        return xml(['data'=>$data,'code'=>'code','message'=>'Done']);
    }
    public function jsonpdata()
    {
        $data = ['name'=>'thinkphp','url'=>'iamcaojie.com'];
        return jsonp(['data'=>$data,'code'=>'code','message'=>'Done']);
    }
}
