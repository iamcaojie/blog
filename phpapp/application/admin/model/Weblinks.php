<?php 
namespace app\admin\model;

use think\Model;

class Web extends Model
{
    public function getWebStatus()
    {
        return $this->where('name','blog');
    }
    // public function getWebStatus()
    // {
        
    // }
}