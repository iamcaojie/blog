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

// 首页6个图标
Route::get(['web/doc'=>'web/Index/doc']);

Route::rule('index','blog/Index/index');
//Route::rule('blog/contents/:cate/:page','blog/Contents/index','GET');
// 路由无法生效 TODO
//Route::rule('blog/detail','blog/Detail/index','GET');
//Route::rule('user/:id','user/Index/index','GET');


// 正则限制变量规则
// Route::pattern([
    // 'name'  =>  '\w+',// 单词字符
    // 'age'    =>  '\d+',// 数字
// ]);

// 路由表达式
// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     'blog/detail/["id"]'     =>
//         ['blog/Detail/index', ['method' => 'get'], ['id' => '\d+']]
//
// ];
