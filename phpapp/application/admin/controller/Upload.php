<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

// 所有需登录的控制器继承此类
class Upload extends Base
{
    // 验证，会覆盖Base类的_initialize
    // public function _initialize()
    //{
    //     echo 'hello world';
    // }

    // 轮播图上传
    public function carousel()
    {
        // 前端是单文件上传
        $imageCount = Db::name('image')->where('imagecate_id','1') ->count();
        if($imageCount>=3){
            return json(['code' => 0, 'msg' => '轮播图已有3张']);
        }
        $files = request()->file();
        $infoBox = [];
        $imageCateData = Db::name('imagecate')->where('id',1)->find();
        $address = $imageCateData['dir'];
        foreach ($files as $file) {
            if($file->validate(['ext'=>'jpg,png,gif'])){
                $name = md5($file);
                $info = $file -> rule('md5')->move(IMAGE_PATH . $address,$name);
                if($info){
                    $ext = $info -> getExtension();
                    array_push($infoBox, $name);
                    // 把图片路径入数据库
                    $ImageData =  Db::name('image')
                            -> where('imagecate_id',1)
                            -> where('address',$name)->find();
                    if(!$ImageData){
                        Db::name('image')->insert([
                            'imagecate_id'=>1,
                            'address'=>$name,
                            'ext'=>$ext
                        ]);
                    }
                }else{

                }
            }else{
                $name = md5($file);
                array_push($infoBox, $name);
            }
        }
        return json(['code' => 0,
            'msg' => '轮播图上传成功',
            'data'=>$infoBox
        ]);
    }
}