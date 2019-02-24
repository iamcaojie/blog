<?php
namespace org;
use think\Request;
use think\Db;

class CheckClient
{
    // 检测请求域名是否正常
    public static function checkHost()
    {
        $request = Request::instance();
        $webData = Db::name('web')->where('id',1)->find();
        $requsetHost = $request->domain();
        $requestDomain = preg_replace('/(http|https):\/\//','',$requsetHost);
        if ($webData['domain'] == $requestDomain){
            return true;
        }else{
            // 记录ip;
            return false;
        }
    }
    // 检测空agent或者ie11以下
    public static function checkAgent()
    {
        $clientData = [];
        $agent = Request::instance()->header('user-agent');
        $isIE = strpos($agent,'Trident');
        if($isIE){
            if(boolval(strpos($agent,"rv:1"))){
                return true;
            }else{
                return false;
            }
        }
        return true;
    }
}