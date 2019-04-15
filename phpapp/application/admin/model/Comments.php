<?php 
namespace app\admin\model;

use think\Model;

class Comments extends Model
{
    public static function formatComment($data)
    {
        foreach ($data as $value)
        {
            // 根据评论user_id查询用户数据
            $value['user'] = db('users')
                -> where('id',$value['user_id'])
                -> find();
            $value['nickname'] = $value['user']['nickname'];
            // 查询评论对应博客文章标题
            $value['blog_title'] = db('blog')
                ->where('id',$value['blog_id'])
                ->field('blog_title')
                ->find()['blog_title'];
            // 查询评论是否有回复
            $replyData = db('reply')
                -> where('comment_id',$value['id'])
                -> select();
            // 查询每条回复的用户信息
            $formatReplyData = [];
            foreach ($replyData as $replyValue){
                // 格式化回复时间
                $replyValue['create_time'] = date('Y-m-d H:m:s',$replyValue['create_time']);
                // 写入回复人
                $replyValue['user'] = db('users')
                    -> where('id',$replyValue['user_id'])
                    -> find();
                $formatReplyData[] = $replyValue;
            }
            $value['reply'] = $formatReplyData;
        }
        return $data;
    }
    // 查询所有评论
    public static function getCommentsList($page,$limit)
    {
        $commentList = self::limit(($page-1)*$limit,$limit)
            -> select();
        $commentList = self::formatComment($commentList);
        $count = self::count();
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

    // 删除评论，同时删除评论的所有回复
    public static function deleteComments($id)
    {
        $info = self::destroy(['id'=>$id]);
        if($info){
            db('reply')
                -> where('comment_id',$id)
                ->delete();
        }
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

    // 根据用户查询评论
    public static function getUserComments($userId)
    {
        $data = self::where('user_id',$userId)
            ->select();
        return $data;
    }
}