<?php 
namespace app\admin\model;

use think\Model;

class Favorite extends Model
{

//    public static function getFavoriteList()
//    {
//        return self::select();
//    }

//    public static function editFavorite($data)
//    {
//        $info = self::update($data);
//        return $info;
//    }

    // 根据blog_id获取文章详情
    protected static function formatData($data)
    {
        foreach ($data as $k=>$v)
        {
            $v['blog'] = db('blog')->where('id',$v['blog_id'])
                ->field('id,blog_title')
                ->find();
        }
        return $data;
    }

    // 收藏，取消收藏（个人中心，文章详情页）
    public static function favorite($userId,$blogId)
    {
        $isFavorite = self::where('user_id',$userId)
            ->where('blog_id',$blogId)
            ->find();
        if($isFavorite){
            $info = self::destroy(['id'=>$isFavorite['id']]);
            if($info) return ['code'=>0,'msg'=>'未收藏'];
        }
        $info = self::create(['user_id'=>$userId,'blog_id'=>$blogId]);
        if($info) return ['code'=>0,'msg'=>'已收藏'];
    }

    // 获取收藏状态（文章详情页）
    public static function getFavorite($userId,$blogId)
    {
        $isFavorite = self::where('user_id',$userId)
            ->where('blog_id',$blogId)
            ->find();
        return $isFavorite;
    }

    // 根据用户id查询收藏（个人中心）
    public static function queryFavorite($userId)
    {
        $favoriteList = self::where('user_id',$userId)->select();
        $favoriteList = self::formatData($favoriteList);
        return $favoriteList;
    }
}
