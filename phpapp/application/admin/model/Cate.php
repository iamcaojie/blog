<?php 
namespace app\admin\model;

use think\Model;


class Cate extends Model
{
    // 一个分类对应多篇文章
    public function blog()
    {   
        return $this->hasMany('Blog','cate_id','id');
    }

    // 查询所有数据，不排序
    public static function getCateList()
    {
        return self::where('delete_time',null)
            ->select();
    }

    // 查询所有数据，排序
    public static function getCateTree()
    {
        $data = self::where('delete_time',null)
            ->select();
        $arr = sortTree($data);
        return $arr;
    }

    public static function createCate($data)
    {
        $info = self::create($data,true);
        return $info;
    }
    
    public static function editCate($data)
    {
        $info = self::update($data);
        return $info;
    }
    // 标记删除
    public static function deleteCate($id)
    {
        $info = self::where('id', 1)
            ->update(['name' => 'thinkphp']);
        return ["data"=>""];
    }

    // 硬删除
    // 删除所有子分类
    // 删除所有分类下的文章

    // 查询分类
    public static function queryCate($id)
    {
        $data = self::get($id);
        return $data;
    }
}
