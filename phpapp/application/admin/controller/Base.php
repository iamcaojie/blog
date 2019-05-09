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
        // 非法域名
//        if (!CheckClient::checkHost()){
////            $this->redirect('/');
//        }
        // 登陆用户
        $userID = session('user')['id'];
        if ($userID){
            $auth = new Auth();
            // 不是管理员用户就重定向到个人中心界面
            if($userID>2){
                $this->redirect('/user?id='.$userID);
            }
            // 管理员和测试测试管理员
            $con = strtolower(request()->controller());
            $action = strtolower(request()->action());
            $name = $con.'/'.$action;
            $result = $auth ->check($name,$userID);
            if(!$result){
                json(['code'=>-1,'msg'=>'暂无权限'])->send();
                exit;
            }
        }else{
            $this->redirect('/');
        }
    }
}