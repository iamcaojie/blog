<?php
namespace app\user\controller;

use app\admin\model\Users as UsersModel;

class Index
{
    // 用户显示页面
    public function index($userid = 1)
    {
        // 判断是否为本人访问（是则为后台，否则为用户界面）
        // 用户后台（文章发布，修改，删除，仅能修改自己的，关注，取消关注）
        // 获取关注列表

        // 获取粉丝列表

        //

        //
        return view('user/user');
    }

    // 关注，取消关注


}
