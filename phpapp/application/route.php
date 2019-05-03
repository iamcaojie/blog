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
/*
 * /blog/index/index
 * /blog/contents/index
 * /blog/detail/index/id/{n}
 *
 * /user?id={n}
 * /user/index/index/id/{n}
 *
 * /admin
 *
 */

use think\Route;

//Route::rule('index','blog/Index/index');
//Route::rule('blog/contents/:cate/:page','blog/Contents/index','GET');
//Route::rule('blog/detail/:id','blog/Detail/index','GET');
//Route::rule('user/:id','user/Index/index','GET');

// 正则限制变量规则
// Route::pattern([
    // 'name'  =>  '\w+',// 单词字符
    // 'age'    =>  '\d+',// 数字
// ]);

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
