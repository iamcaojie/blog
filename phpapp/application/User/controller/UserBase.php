<?php
namespace app\user\controller;

use app\blog\controller\Base;

// 继承blog的全局base，扩展用
class UserBase extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }
}
