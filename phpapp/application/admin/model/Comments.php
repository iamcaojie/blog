<?php 
namespace app\admin\model;

use think\Model;

class Comments extends Model
{
    // 查询所有数据
    // sql:select * from _comments;
    public static function getCommentsList($page,$limit)
    {
        $list = self::where('delete_time',null) -> limit(($page-1)*$limit,$limit) -> select();
        $count = self::where('delete_time',null) -> count();
        return ["code"=>0,"msg"=>"列表查询完成","count"=>$count,"data"=>$list];
    }
    // 创建评论，只能在评论页调用
    public static function createComments($data)
    {
        $info = self::create($data, true);
        if($info){
            return ["code"=>0, "msg"=>"评论已发布"];
        }else{
            return ["code"=>-1, "msg"=>"评论发布失败"];
        }
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
        $deleteComment = self::get($id);
        $deleteComment -> delete_time = strtotime('now');
        $deleteComment -> save();
        return ["code"=>0, "msg"=>"删除成功"];
    }
    // 根据博客id查询博客评论
    public static function queryComments($id)
    {
      $data = self::where('delete_time',null)
          ->where('blog_id',$id)
          ->select();
      if($data){
          return ["code"=>0, "msg"=>"评论查询完成", "data"=>$data];
      }else{
          return ["code"=>-1, "msg"=>"暂无评论", "data"=>$data];
      }
    }
}