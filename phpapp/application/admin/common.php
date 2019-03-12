<?php
/* 截断字符串
 * @param string $str
 * @param
 * @param
 */
function sub_str($str, $length = 100, $append = true)
{
    $str = trim($str);
    $strLength = strlen($str);
    if ($length >= $strLength){
        return $str; //截取长度等于或大于等于本字符串的长度，返回字符串本身
    }
    elseif ($length < 0){ //如果截取长度为负数
         $length = $strLength + $length;//那么截取长度就等于字符串长度减去截取长度
         if ($length >= $strLength){
            $length = $strLength;//如果截取长度的绝对值大于字符串本身长度，则截取长度取字符串本身的长度
         }
    }
    if (function_exists('mb_substr')){
        $newstr = mb_substr($str,0,$length,'utf-8' );
    } elseif (function_exists('iconv_substr')){
        $newstr = iconv_substr($str,0,$length, 'utf-8');
    } else{
        //$newstr = trim_right(substr($str, , $length));
        $newstr = substr($str,$length);
    }
    if ($append && $str != $newstr)
    {
        $newstr .= '...';
    }
    return $newstr;
}

/* 递归排序无限分类
 * @param array $data
 * @param int $pid
 * @param int $level
 */
function sortTree($data, $pid=0, $level=0)
{
    static $arr = []; // 静态数组
    foreach($data as $k=>$v){
        if($v['pid']==$pid){
            $v['level'] = $level; // 给单条数据添加level字段
            $arr[] = $v; // 首先把顶级分类添加到静态数组中
            sortTree($data, $v['id'],$level+1); // 递归求解当前栏目的下一栏目
        }
    }
    return $arr;
}