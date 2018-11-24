<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 注册路由
//注册路由到index模块的Index控制器的hello操作

use think\Route;
Route::rule('index/','index/Index/index');
Route::rule('json/','index/Index/jsondata');
Route::rule('xml/','index/Index/xmldata');
Route::rule('baidu/','https://www.baidu.com');
Route::rule('hello/:name/:age','index/Index/hello',"GET",['ext'=>'html']);

// 正则限制变量规则
Route::pattern([
    'name'  =>  '\w+',// 单词字符
    'age'    =>  '\d+',// 数字
]);

// 路由表达式
// return [
    // '__pattern__' => [
        // 'name' => '\w+',
    // ],
    // '[hello]'     => [
        // ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        // ':name' => ['index/hello', ['method' => 'post']],
    // ],
    // 'my'  => ['index'=> /index]
// ];
