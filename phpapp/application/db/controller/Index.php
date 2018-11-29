<?php
namespace app\db\controller;

use think\View;
use think\Request;
use think\Db;
class Index
{
    public function index()
    {
        print_r(Db::query('select * from think_user where id=?',[8]));
        
        // print_r(Db::table('think_user')->where('id',2)->find());
    }
}
