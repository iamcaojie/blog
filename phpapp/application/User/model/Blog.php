<?php 
namespace app\user\model;

use think\Model;

class Blog extends Model
{
    
    // 相对与分类的一对多关联
    public function cate()
    {
        return $this->belongsTo('cate','cate_id','id');
    }
    
    // 标签与博客多对多关联
    public function tags()
    {
        return $this->belongsToMany('tags','blogs_tags','tag_id','blog_id');
    }
    
    // 博客与评论一对多关联
    public function comments()
    {
        return $this->hasMany('comments',' ','tag_id');
    }
    
    // 获取博客列表
    public static function getBlogList($page,$limit)
    {
        $bloglist = [];
        $pagelist = self::where('delete_time',null) -> limit(($page-1)*$limit,$limit) -> select();
        $blogcount = self::where('delete_time',null) -> count();

        // 查询原始分类数据 查询原始标签数据并添加
        foreach ($pagelist as $value){
            $value['cate'] = self::get($value['id']) -> cate -> blog_category;
            $tag = [];
            foreach(self::get($value['id']) -> tags as $temp)
            {
                array_push($tag, $temp['tag']);
            }
            $value['tag'] = $tag;
            array_push($bloglist,$value);
        }
        return ["code"=>0,"msg"=>"列表查询完成","count"=>$blogcount,"data"=>$bloglist];
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
        $deleteblog = self::get($id);
        $deleteblog -> delete_time = strtotime('now');
        $deleteblog -> save();
        return ["code"=>0, "msg"=>"删除成功"];
    }   
    // 编辑关联数据，仅编辑关联的中间表数据
    public static function editBlog($data)
    {
//        更新数据
        $blog = self::update($data["blogdata"]);
//        删除所有关联，再添加新的关联
        $editblog = self::get($data["blogdata"]['id']);
        $editblog -> tags() -> detach();
        $editblog-> tags() -> saveAll($data["tagdata"]);
        return ["code"=>0, "msg"=>"修改成功"];
    }
    // 查询表数据，返回关联表的标签id
    public static function queryBlog($id)
    {
        $blog = self::get($id);
        $tag = [];
        foreach($blog -> tags as $temp)
        {
            array_push($tag,$temp['id']);
        }
        $blog['tags'] = $tag;
        return ["code"=>0,"msg"=>"查询完成","data"=>$blog];
    }
}