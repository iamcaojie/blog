<?php 
namespace app\blog\model;

use think\Model;

class Detail extends Model
{
    protected $table = 'think_blog';
    
    public function queryBlog($id)
    {
        $blog = $this->where('id',$id)->find();
        return ["code"=>0,"msg"=>"查询完成","data"=>$blog];
    }
}