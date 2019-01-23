<?php 
namespace app\admin\model;

use think\Model;


class Downloads extends Model
{

    // 静态方法，查询所有数据
    // sql:select * from _downloads;
    public static function getDownloadsList()
    {
        return self::select();
    }
    
    public static function createDownloads($data)
    {
        self::create($data);
        return ["data"=>""];
    }
    
    public static function editDownloads($data)
    {
        self::update($data);
        return ["data"=>""];
    }
    
    public static function deleteDownloads($data)
    {
        self::destroy($data);
        return ["data"=>""];
    }
    
    public static function queryDownloads($data)
    {
        //pass
    }
}
