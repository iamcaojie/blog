<?php
namespace app\admin\controller;

use think\Controller;
use org\Auth;
use org\CheckClient;

// 所有需登录的控制器继承此类
class Base extends Controller 
{
    public function _initialize()
    {
        // 非法域名，记录ip
        if (!CheckClient::checkHost()){
//            $this->redirect('/');
        }
        // IE10以下浏览器访问
//        if(!CheckClient::checkAgent()){
//            $this->redirect('/login');
//        }
        // 登陆用户
        $userID = session('user')['user_id'];
        if ($userID){
            $auth = new Auth();
            $module = strtolower(request()->module());
            $con = strtolower(request()->controller());
            $action = strtolower(request()->action());
            $name = $con.'/'.$action;
            $result = $auth ->check($name,$userID);
//            if(!$result){
//                json(['code'=>-1,'msg'=>'暂无权限'])->send();
//                exit;
//            }
        }else{
//            $this->redirect('/login');
        }
    }
}