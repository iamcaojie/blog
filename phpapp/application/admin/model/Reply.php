<?php
namespace app\admin\model;

use think\Model;
class Reply extends Model
{
    // 回复评论
    public static function reply($data)
    {
        $info = self::create($data);
        return $info;
    }

    // 查询回复
    public static function queryReply($data)
    {

    }

    // 删除回复
    public static function deteleReply($data)
    {

    }

    // 修改回复
    // pass
}
