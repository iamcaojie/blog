<?php 
namespace app\admin\model;

use think\Model;


class AuthGroup extends Model
{

    public static function getAuthGroupList()
    {
        $data = self::select();
        $authGroupData = sortTree1($data, $pid=0, $level=0);
        return $authGroupData;
    }
    
    public static function createAuthGroup($data)
    {
        $info = self::create($data);
        return $info;
    }
    
    public static function editAuthGroup($data)
    {
        $info = self::update($data);
        return $info;
    }
    
    public static function deleteAuthGroup($data)
    {
        $info = self::destroy($data);
        return $info;
    }
    
    public static function queryAuthGroup($data)
    {
        //pass
    }

    // 获取子分类
    public function getChildrenId($id){
        $data = self::select();
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
}
