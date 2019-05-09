<?php
namespace app\admin\controller;

use think\Db;

// 所有上传文件通过此控制器管理
class Upload extends Base
{

    // 上传轮播图，id为1
    public function banner()
    {
        // 前端是单文件多次上传，后端支持多文件上传
        // 判断轮播图数量
        $imageCount = db('image')
            ->where('imagecate_id','1')
            ->count();
        if($imageCount>=3){
            return json(['code' => 0, 'msg' => '轮播图已有3张']);
        }
        $files = request()->file();
        $infoBox = [];
        $imageCateData = db('imagecate')->where('id',1)->find();
        $address = $imageCateData['dir'];
        foreach ($files as $file) {
            if($file->validate(['ext'=>'jpg,png,gif'])){
                $name = md5($file);
                $info = $file -> rule('md5')->move(IMAGE_PATH . $address,$name);
                // 判断图片是否存储成功
                if($info){
                    $ext = $info -> getExtension();
                    // 查询图片是否重复
                    $imageInfo =  db('image')
                        -> where('imagecate_id',1)
                        -> where('address',$name)->find();
                    // 如果没有就继续存入数据库，有就是不存
                    if(!$imageInfo){
                        $imageId = db('image')->insertGetId([
                            'imagecate_id'=>1,
                            'address'=>$name,
                            'ext'=>$ext
                        ]);
                        $imageInfo = db('image')
                            -> where('id',$imageId)
                            -> find();
                    }
                    array_push($infoBox, $imageInfo);
                }else{
                    // 上传失败
                    return json(['code' => -1, 'msg' => '主图上传失败']);
                }
            }else{
                // 不是图片文件
                return json(['code' => -1, 'msg' => '非法文件']);
            }
        }
        return json(['code' => 0, 'msg' => '主图上传成功', 'data'=>$infoBox]);
    }

    // 上传主图，前端是diyupload单文件上传，后端支持多文件上传
    public function master()
    {
        $files = request()->file();
        $infoBox = [];
        $imageCateData = db('imagecate')->where('id',2)->find();
        $address = $imageCateData['dir'];
        foreach ($files as $file) {
            if($file->validate(['ext'=>'jpg,png,gif'])){
                $name = md5($file);
                $info = $file -> rule('md5')->move(IMAGE_PATH . $address,$name);
                // 判断图片是否存储成功
                if($info){
                    $ext = $info -> getExtension();
                    // 查询图片是否重复
                    $imageInfo =  db('image')
                        -> where('imagecate_id',2)
                        -> where('address',$name)->find();
                    // 如果没有就继续存入数据库，有就是不存
                    if(!$imageInfo){
                        $imageId = db('image')->insertGetId([
                            'imagecate_id'=>2,
                            'address'=>$name,
                            'ext'=>$ext
                        ]);
                        $imageInfo = db('image')
                            -> where('id',$imageId)
                            -> find();
                    }
                    array_push($infoBox, $imageInfo);
                }else{
                    // 上传失败
                    return json(['code' => -1, 'msg' => '主图上传失败']);
                }
            }else{
                // 不是图片文件
                return json(['code' => -1, 'msg' => '非法文件']);
            }
        }
        return json(['code' => 0, 'msg' => '主图上传成功', 'data'=>$infoBox]);
    }

    // 编辑器上传详情图,{'errno':0,'data':[, , ,]}
    public function detail(){
        $files = request()->file();
        $imageUrl = [];
        $imageCateData = db('imagecate')->where('id',3)->find();
        $address = $imageCateData['dir'];
        foreach ($files as $file) {
            if($file->validate(['ext'=>'jpg,png,gif'])){
                $name = md5($file);
                $info = $file -> rule('md5')->move(IMAGE_PATH . $address,$name);
                // 判断图片是否存储成功
                if($info){
                    $ext = $info -> getExtension();
                    // 查询图片是否重复
                    $imageInfo =  db('image')
                        -> where('imagecate_id',3)
                        -> where('address',$name)->find();
                    // 如果没有就继续存入数据库，有就是不存
                    if(!$imageInfo){
                        $imageId = db('image')->insertGetId([
                            'imagecate_id'=>3,
                            'address'=>$name,
                            'ext'=>$ext
                        ]);
                        $imageInfo = db('image')
                            -> where('id',$imageId)
                            -> find();
                    }
                    array_push($imageUrl,'/uploads/'.$address.'/'. $imageInfo['address'].'.'.$imageInfo['ext']);
                }else{
                    // 上传失败
                    return json(['errno' => -1]);
                }
            }else{
                // 不是图片文件
            }
        }
        return json(['errno' => 0,'data'=>$imageUrl]);
    }
}