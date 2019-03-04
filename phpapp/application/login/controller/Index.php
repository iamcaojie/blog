<?php
namespace app\login\controller;

use think\Controller;
use think\Db;
use app\admin\model\Users as Usersmodel;
use app\admin\model\Web as Webmodel;
use PHPMailer\QQMailer;


// 一切登陆相关操作
class Index extends Controller
{
    public function index()
    {
        if(session('user')){
            $this ->redirect('/admin');
        }
        $webData = Webmodel::get(1);
        return view('login/login',
            ['webdata'=>$webData
        ]);
    }
    // 登陆
    public function validateLogin()
    {
        $data = input('post.');
        $userData = Usersmodel::queryUser($data);
        if ($userData === null){
            return json(["code"=>-1, "msg"=>"该账号未注册"]);
        }
        $data = passWordMd5($data);
        $userData = Usersmodel::validateuser($data);
        if (!($userData === null)){
            session('user',['user_id'=>$userData["id"],"username"=>$userData["username"]]);
            if(($userData["id"]) !=1){
                return json(["code"=>0,"msg"=>"登陆成功","url"=>"/user"]);
            }else{
                return json(["code"=>0,"msg"=>"登陆成功","url"=>"/admin"]);
            }
        }else{
            return json(["code"=>-1,"msg"=>"用户名或密码错误"]);
        }
    }

    // 验证登陆状态
    public function isLogin()
    {
        if(session('?user_id')){
            return json(["code"=>0, "msg"=>"已登陆","user_id"=>session('user_id')]);
        }else{
            return json(["code"=>-1, "msg"=>"未登录"]);  
        }
    }
    // 登出
    public function LoginOff()
    {
        $user = session('user');
        session(null);
        $this->redirect('/login');
    }
    // 注册，找回密码发送邮件
    public function sendMail()
    {
        $data = input('post.');
        // 验证邮箱合法性
        if(!isEmail($data['username'])){
            return json(["code"=>-1, "msg"=>"邮箱格式不合法"]);
        }
        $vcode = mt_rand(1000,9999);
        session('vcode',['username'=>$data['username'],'vcode'=>$vcode]);
        $title = '验证码';
        $webData = Db::name('web')->where('id',1)->find();
        $content = '<p>您正在'.$webData['domain'].'上申请'.$data['action'].'</p>'
            . '<p>您的账号为</p>'
            . '<p>'.$data['username'].'</p>'
            . '<p>您的验证码为</p>'
            . '<p align="center"><b>'.$vcode.'</b></p>'
            . '<p align="right">5分钟内有效</p>'
            . '<p align="right">如非本人操作请忽略QAQ</p>';
        $msg = $data['action'].'验证码已发送,请查收';
        $mailer = new QQMailer();
        $info = $mailer->send('1041973277@qq.com', $title, $content);
        if($info){
            return json(['code'=>0, 'msg'=>$msg]);
        }else{
            return json(['code'=>0, 'msg'=>'发送失败']);
        }

    }
    // 注册
    public function register()
    {
        $data = input('post.');
        // 验证邮箱合法性
        if (!isEmail($data['username'])) {
            return json(["code" => -1, "msg" => "邮箱格式不合法"]);
        }
        if(session('vcode') != ['username'=>$data['username'],'vcode'=>$data['vcode']]){
            return json(["code"=>-1,"msg"=>"验证码错误"]);
        }
        session('vcode',null);
        $data = passWordMd5($data);
        $userData = Usersmodel::queryUser($data);
        if ($userData === null){
            Usersmodel::create($data,true);
            return json(["code"=>0, "msg"=>"注册成功"]);
        } else{
            return json(["code"=>-1, "msg"=>"该账号已注册"]);
        }
    }
    // 重置密码
    public function resetPassword()
    {
        $data = input('post.');
        // 验证邮箱合法性
        if (!isEmail($data['username'])) {
            return json(["code" => -1, "msg" => "邮箱格式不合法"]);
        }
        if(session('vcode') != ['username'=>$data['username'],'vcode'=>$data['vcode']]){
            return json(["code"=>-1,"msg"=>"验证码错误"]);
        }
        $userData = Usersmodel::queryUser($data);
        if($userData === null){
            return json(["code"=>-1, "msg"=>"该账号未注册"]);
        }
        session('vcode',null);
        $data = passWordMd5($data);
        Usersmodel::editUsers($data);
        return json(["code"=>0,"msg"=>"密码已修改"]);
    }
}
