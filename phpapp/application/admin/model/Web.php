<?php 
namespace app\admin\model;

use think\Model;


class Web extends Model
{
 
    // 静态方法，查询所有数据
    // sql:select * from _web;
    public static function getWebList()
    {
        return self::select();
    }

    public static function editWeb($data)
    {
        $info = self::update($data);
        return $info;
    }
}
