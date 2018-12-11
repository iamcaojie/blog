<?php 
namespace app\admin\model;

use think\Model;

class Massage extends Model
{
    public function getWebStatus()
    {
        return $this->where('name','blog');
    }
    // public function getWebStatus()
    // {
        
    // }
}