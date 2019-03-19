<?php 
namespace app\admin\model;

use think\Model;

class AuthRule extends Model
{

    public static function getAuthRuleList()
    {
        $data = self::select();
        $authRuleData = sortTree($data, $pid=0, $level=0);
        return $authRuleData;
    }
    // 创建规则
    public static function createAuthRule($data)
    {
        $info = self::create($data);
        return $info;
    }
    // 编辑规则
    public static function editAuthRule($data)
    {
        $info = self::update($data);
        return $info;
    }
    // 删除规则
    public static function deleteAuthRule($id)
    {
        // pass
    }
    // 根据id查询规则
    public static function queryAuthRule($data)
    {
        // pass
    }

    // 获取子权限
    public function getChildrenId($id){
        $data = self::select();
        return $this->_getChildrenId($data,$id);
    }

    // 获取子权限
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
