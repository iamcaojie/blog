<?php 
namespace app\admin\model;

use think\Model;

class Tags extends Model
{
    public function common()
    {   
        return $this->hasMany('Comment','uid','user_id');
    }   
}