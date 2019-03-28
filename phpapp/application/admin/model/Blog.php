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
        return $this->hasMany('comments',' ','tag_id');
    }
    // 格式化博客数据
    protected function formatData($data)
    {
        foreach ($data as $value){
            // 写入简略博客详情
            $value['blog_text_omit'] = sub_str(($value['blog_text']),200);
            // 修改时间格式
            $value['update_time_today'] = date('Y-m-s',strtotime($value['update_time']));
            // 格式化个性标签
            $value['unique_tag'] =
                // 写入关联的分类
            $value['cate'] = self::get($value['id']) -> cate -> blog_category;
            $tag = [];
            // 写入关联的标签
            foreach(self::get($value['id']) -> tags as $temp)
            {
                array_push($tag, $temp['tag']);
            }
            $value['tag'] = $tag;
        }
        return $data;
    }

    // 获取博客列表(后台layui调用)
    public static function getBlogList($page,$limit)
    {
        $pagelist = self::where('delete_time',null)
            -> limit(($page-1)*$limit,$limit)
            -> select();
        $blogcount = self::where('delete_time',null)
            -> count();

        // 查询原始分类数据 查询原始标签数据并添加
        foreach ($pagelist as $value){

            // 写入关联的分类
            $value['cate'] = self::get($value['id']) -> cate -> blog_category;
            $tag = [];
            // 写入关联的标签
            foreach(self::get($value['id']) -> tags as $temp)
            {
                array_push($tag, $temp['tag']);
            }
            $value['tag'] = $tag;
        }
        return ["code"=>0,"msg"=>"列表查询完成","count"=>$blogcount,"data"=>$pagelist];
    }

    // 获取博客列表(目录页调用）
    public static function getBlogLists($cate,$page,$limit)
    {
        $pagelist = self::where('delete_time',null)
            -> where('cate_id',$cate)
            -> limit(($page-1)*$limit,$limit)
            -> select();
        $blogcount = self::where('delete_time',null)
            -> where('cate_id',$cate)
            -> count();

        // 查询原始分类数据 查询原始标签数据并添加
        foreach ($pagelist as $value){
            // 写入简略博客详情
            $value['blog_text_omit'] = sub_str(($value['blog_text']),200);
            // 修改时间格式
            $value['update_time_today'] = date('Y-m-s',strtotime($value['update_time']));
            // 写入关联的分类
            $value['cate'] = self::get($value['id']) -> cate -> blog_category;
            $tag = [];
            // 写入关联的标签
            foreach(self::get($value['id']) -> tags as $temp)
            {
                array_push($tag, $temp['tag']);
            }
            $value['tag'] = $tag;
        }
        return ["code"=>0,"msg"=>"列表查询完成","count"=>$blogcount,"data"=>$pagelist];
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
        $editblog = self::get($data["blogdata"]['id']);
        $editblog -> tags() -> detach();
        $editblog-> tags() -> saveAll($data["tagdata"]);
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
        $tag = [];
        foreach($blog -> tags as $temp)
        {
            array_push($tag,$temp['id']);
        }
        $blog['tags'] = $tag;
        return ["code"=>0,"msg"=>"查询完成","data"=>$blog];
    }

    public static function getLastUpdate()
    {
        $LastUpdateData = self::where('detele_name',null)
            ->order('update_time desc')
            ->limit(10)
            ->select();
        // 查询原始分类数据 查询原始标签数据并添加
        foreach ($LastUpdateData as $value){
            // 写入简略博客详情
            $value['blog_text_omit'] = sub_str(($value['blog_text']),200);
            // 修改时间格式
            $value['update_time_today'] = date('Y-m-s',strtotime($value['update_time']));
            // 格式化个性标签
            $value['unique_tag'] =
            // 写入关联的分类
            $value['cate'] = self::get($value['id']) -> cate -> blog_category;
            $tag = [];
            // 写入关联的标签
            foreach(self::get($value['id']) -> tags as $temp)
            {
                array_push($tag, $temp['tag']);
            }
            $value['tag'] = $tag;
        }
        return $LastUpdateData;
    }

}