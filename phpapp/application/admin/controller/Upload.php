<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

// 所有上传文件通过此控制器管理
class Upload extends Base
{

    public function index()
    {
        // 图片管理
    }

    // 上传轮播图，id为1
    public function carousel()
    {
        // 前端layui是单文件多次上传
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
                    // 查询图片是否重复
                    $ImageData =  Db::name('image')
                            -> where('imagecate_id',1)
                            -> where('address',$name)->find();
                    // 如果没有就继续存入，有就是不存
                    if(!$ImageData){
                        Db::name('image')->insert([
                            'imagecate_id'=>1,
                            'address'=>$name,
                            'ext'=>$ext
                        ]);
                    }
                }else{
                    //pass
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

    // 上传主图，单文件上传
    public function masterImage(){

    }

    // 编辑器上传详情图
    public function datailImage(){

    }

}