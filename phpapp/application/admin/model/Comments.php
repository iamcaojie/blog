<?php 
namespace app\admin\model;

use think\Model;

class Comments extends Model
{
    public static function formatComment($data)
    {
        foreach ($data as $value)
        {
            // 根据id查询用户昵称数据
            $value['user'] = db('users')
                ->where('id',$value['user_id'])
                ->field('nickname') ->find();
        }
        return $data;
    }
    // 查询所有评论
    public static function getCommentsList($page,$limit)
    {
        $commentList = self::where('delete_time',null)
            -> limit(($page-1)*$limit,$limit)
            -> select();
        $count = self::where('delete_time',null) -> count();
        return ["code"=>0,"msg"=>"列表查询完成","count"=>$count,"data"=>$commentList];
    }

    // 创建评论，只能在评论页调用
    public static function createComments($data)
    {
        $info = self::create($data, true);
        return $info;
    }

    //  编辑评论，暂无需求
    public static function editComments($data)
    {
        // self::update($data);
        // return ["data"=>""];
    }

    // 删除评论
    public static function deleteComments($id)
    {
        $info = self::destroy(['id'=>$id]);
        return $info;
    }

    // 根据博客id查询博客评论
    public static function queryComments($id)
    {
      $data = self::where('blog_id',$id)
          ->select();
      $data = self::formatComment($data);
      return $data;
    }
}