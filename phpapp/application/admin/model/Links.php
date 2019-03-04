<?php 
namespace app\admin\model;

use think\Model;

class Links extends Model
{

    // 相对与链接分类的多对一关联
    public function linkcates()
    {
        return $this->belongsTo('Linkcate','link_cate_id','id');
    }

    // sql:select * from _links;
    public static function getLinksList($page,$limit)
    {
        $linkList = [];
        $linkDatas = self::where('delete_time',null)
            -> limit(($page-1)*$limit,$limit)
            -> select();
        $linkCount = self::where('delete_time',null)
            -> count();
        // 写入关联的分类
        foreach ($linkDatas as $linkData){
                $linkCateData = self::get($linkData['id'])
                    -> linkcates
                    ->link_cate_title;
                $linkData['link_cate_title'] = $linkCateData;
            }
        return ["count"=>$linkCount,"data"=>$linkDatas];
    }
    
    public static function createLinks($data)
    {
        self::create($data);
        return ["code"=> 0, "data"=>"创建链接成功"];
    }
    
    public static function editLinks($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteLink($data)
    {
        $info = self::destroy($data);
            return $info;
    }
    
    public static function queryLink($id)
    {
        $linkData = self::get($id);
        return $linkData;
    }
}
