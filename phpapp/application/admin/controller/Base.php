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
            $con = strtolower(request()->controller());
            $action = strtolower(request()->action());
            $auth = new Auth();
            if($con == 'upload'){
                //pass
            }else{
                // 不是管理员用户就重定向到个人中心界面
                $info = $auth->getGroups($userID); // 一个用户可能对应多个用户组
                foreach ($info as $k){
                    if($k['group_id']>3){
                        $this->redirect('/user?id='.$userID);
                        exit;
                    }
                }
            }
            // 管理员和测试管理员
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