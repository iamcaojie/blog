<?php
namespace app\admin\controller;

use app\admin\model\Cate as CateModel;
use app\admin\model\Blog as BlogModel;

class Conf extends Base
{
    public function index()
    {
        return view('conf/conf');
    }
}
