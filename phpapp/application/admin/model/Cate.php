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
    // 编辑和标记删除
    public static function editCate($data)
    {
        $info = self::update($data);
        return $info;
    }

    // 完全删除
    public static function deleteCate(){

    }
    // 获取子分类
    public function getChildrenId($id){
        $data = self::where('delete_time',null)
            ->select();
        return $this->_getChildrenId($data,$id);
    }
    // 获取子分类
    public function _getChildrenId($data,$id){
        static $arr = [];
        foreach ($data as $k=>$v){
            if($v['pid'] == $id){
                $arr[]=$v['id'];
                $this->_getChildrenId($data,$v['id']);
            }
        }
        return $arr;
    }

    // 查询分类
    public static function queryCate($id)
    {
        $data = self::get($id);
        return $data;
    }

    // 查询一二级分类，导航中使用
    public static function queryNav()
    {
        // 一级分类
        $topLevelData = self::where('pid',0)
            -> select();
        foreach($topLevelData as $key=>$value){
            // 二级分类
            $SecondLevelData = self::where('pid',$value['id'])
                -> select();
            if($SecondLevelData){
                $topLevelData[$key]['SecondLevelCate'] = $SecondLevelData;
            }else{
                $topLevelData[$key]['SecondLevelCate'] = '';
            }
        }
        return $topLevelData;
    }

}
