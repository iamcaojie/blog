<?php
namespace app\admin\validate;

use think\Validate;

class Data extends Validate
{
    protected $rule = [
        'name'  =>  'checkName:thinkphp',
        'email' =>  'email',
    ];

    protected $message = [
        'name'  =>  '用户名必须',
        'email' =>  '邮箱格式错误',
    ];

    // 自定义验证规则
    protected function checkName($value,$rule,$data)
    {
        return $rule == $value ? true : '名称错误';
    }
}