<?php
namespace app\db\controller;

use think\View;
use think\Request;
use think\Db;
class Index
{
    public function index()
    {
        // 初始化数据库
        // print_r(Db::query('show tables'));
        // 创建表
        echo '初始化数据库';
        $sql = ['create table m(id int(10) ,a varchar(30),primary key(id))',
            '',
        ];
        foreach ($sql as $value)
        {
            try
            {
               print_r(Db::execute($value)); 
            }
            catch(Exception $e)
            {
                echo 'Message: ' .$e->getMessage();
            }
            
        }
    }
}
