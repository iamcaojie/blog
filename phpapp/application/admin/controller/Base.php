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
        if(!CheckClient::checkAgent()){
//            $this->redirect('/login');
        }
        // 登陆用户
        $userID = session('user_id');
        if ($userID){
            $auth = new Auth();
            $a = $auth ->getGroups($userID);
        }else{
            $this->redirect('/login');
        }
    }
}