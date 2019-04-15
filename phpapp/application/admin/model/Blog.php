<?php 
namespace app\admin\model;

use think\Model;

// update_time格式在database中设置
// layui数据规范{"code":0,"msg":"","count":n,"data":[]}
// 0:正常; -1:错误;

class Blog extends Model
{
    
    // 相对与博客分类的一对多关联
    public function cate()
    {
        return $this->belongsTo('Cate','cate_id','id');
    }
    
    // 标签与博客多对多关联
    public function tags()
    {
        return $this->belongsToMany('tags','blogs_tags','tag_id','blog_id');
    }
    
    // 博客与评论一对多关联
    public function comments()
    {
        return $this->hasMany('comments','id','tag_id');
    }
    // 格式化博客数据
    protected static function formatData($data)
    {
        foreach ($data as $value){

            // 写入简略博客详情
            if(isset($value['blog_text'])){
                $value['blog_text_omit'] = sub_str(($value['blog_text']),200);
            }

            // 修改时间格式
            $value['f_update_time'] = date('Y-m-d',strtotime($value['update_time']));

            // 格式化个性标签
            if(isset($value['unique_tag'])){
                if(strpos($value['unique_tag'],',') === false){
                    $value['f_unique_tag'] = '';
                }else{
                    $value['f_unique_tag'] = explode(',',$value['unique_tag']);
                }
            }

            // 写入关联的分类
            if(isset($value['cate'])){
                $value['f_cate'] = self::get($value['id'])
                    -> cate
                    -> blog_category;
                // 写入关联的标签
                $tag = [];
                foreach(self::get($value['id']) -> tags as $temp)
                {
                    array_push($tag, $temp['tag']);
                }
                $value['tag'] = $tag;
            }
            // 写入作者
            $value['user'] = db('users')
                ->where('id',$value['user_id'])
                ->find();
            // 写入评论数
            $value['commentsCount'] = db('comments')
                -> where('blog_id',$value['id'])
                ->count();
            // 写入图片数据
            $imageData = db('image')
                -> where('id',$value['image_id'])
                -> find();
            $imageCateData = db('imagecate')
                -> where('id',2)
                -> find();
            if($imageData){
                $value['masterimageurl'] = '/uploads/'.$imageCateData['dir'].'/'.$imageData['address'].'.'.$imageData['ext'];
            }else{
                $value['masterimageurl'] = '/uploads/'.$imageCateData['dir'].'/'.'default.jpg';
            }
        }
        return $data;
    }

    // 获取博客列表(后台layui调用)
    public static function getBlogList($page,$limit)
    {
        $blogData = self::where('delete_time',null)
            -> limit(($page-1)*$limit,$limit)
            -> select();
        $blogCount = self::where('delete_time',null)
            -> count();
        $blogData = self::formatData($blogData);
        return ["code"=>0,"msg"=>"列表查询完成","count"=>$blogCount,"data"=>$blogData];
    }

    // 获取博客列表(目录页调用）
    public static function getBlogLists($cate,$page,$limit)
    {
        $blogData = self::where('delete_time',null)
            -> where('cate_id',$cate)
            -> limit(($page-1)*$limit,$limit)
            -> select();
        $blogCount = self::where('delete_time',null)
            -> where('cate_id',$cate)
            -> count();
        $blogData = self::formatData($blogData);
        return ['blogData' => $blogData,'blogCount' => $blogCount];
    }

    public static function createBlog($data)
    {
        self::create($data["blogdata"]);
        // 新增博客的标签数据,tag_data要与前台一致，只能增加关联的中间表数据
        self::get(self::getLastInsID()) -> tags() -> saveAll($data["tagdata"]);
        return["code"=>0, "msg"=>"保存成功"];
    }
    
    // 只标记删除，记录delete_time,int类型
    // 不删除关联数据
    public function deleteBlog($id)
    {
        $deleteBlog = self::get($id);
        $deleteBlog -> delete_time = strtotime('now');
        $deleteBlog -> save();
        return ["code"=>0, "msg"=>"删除成功"];
    }   
    // 编辑关联数据，仅编辑关联的中间表数据
    public static function editBlog($data)
    {
        // 更新数据
        $blog = self::update($data["blogdata"]);
        //  删除所有关联，再添加新的关联
        $editBlog = self::get($data["blogdata"]['id']);
        $editBlog -> tags() -> detach();
        $editBlog-> tags() -> saveAll($data["tagdata"]);
        return ["code"=>0, "msg"=>"修改成功"];
    }

    // 查询表数据，返回关联表的标签id
    public static function queryBlog($id)
    {
        $blog = self::where('id',$id)
            ->where('delete_time',null)
            ->find();
        if(!$blog){
            return ["code"=>-1,"msg"=>"文章不存在"];
        }
        $blog = self::formatData([$blog]);
        return ["code"=>0,"msg"=>"查询完成","data"=>$blog[0]];
    }

    public static function getLastUpdate($count)
    {
        $LastUpdateData = self::where('delete_time',null)
            -> order('update_time desc')
            ->limit($count)
            ->select();
        $LastUpdateData = self::formatData($LastUpdateData);
        return $LastUpdateData;
    }

    public static function getBlogRank($count)
    {
        $blogRankData = self::where('delete_time',null)
            -> order('read_count desc')
            // -> field('blog_title,read_count')
            -> limit($count)
            -> select();
        $blogRankData = self::formatData($blogRankData);
        return $blogRankData;
    }
    // 获取聚合标签
    public static function getTag()
    {
        $tagData = self::where('delete_time',null)
            -> column('unique_tag');
        $tagArrData = [];
        foreach ($tagData as $value){
            if(strpos($value,',') === false){
                // pass
            }else {
                $tempTagArr = explode(',',$value);
                $tagArrData = array_merge($tagArrData,$tempTagArr);
            }
        }
        return $tagArrData;
    }

    // 点赞，取消点赞
    public static function likeBlog($blogId)
    {
        // 判断文章是否存在
    }

    // 获取某个用户的文章
    public static function getUserBlog($userId)
    {
        $blogData = self::where('user_id',$userId)
            ->select();
        $blogData = self::formatData($blogData);
        return $blogData;
    }
}