<?php
namespace app\user\controller;

use app\blog\controller\Base;
use app\admin\model\Users as UsersModel;
use app\admin\model\Image as ImageModel;
use app\admin\model\Blog as BlogModel;
use app\admin\model\Comments as CommentsModel;
use app\admin\model\Follow as FollowModel;

class Index extends Base
{
    // 用户显示页面
    public function index($id = 1)
    {
        // 判断用户是否存在
        if(!UsersModel::get($id)){
            $this->redirect('/');
        }
        // 获取用户头像
        $userImageUrl = UsersModel::getAvatar($id);
        $this->assign(['userImageUrlData'=>$userImageUrl]);
        // 获取用户文章
        $userBlog = BlogModel::getUserBlog($id);
        $this ->assign(['userBlogData'=>$userBlog]);
        $this ->assign(['userBlogCountData'=>count($userBlog)]);
        // 获取用户评论
        $userComments = CommentsModel::getUserComments($id);
        $this ->assign(['userCommentsData'=>$userComments]);
        $this ->assign(['userCommentsCountData'=>count($userComments)]);
        // 未登录，全部显示'加关注'
        if(!session('?user')){
            // 获取用户关注
            $userFollow = FollowModel::getFollower($id);
            $this ->assign(['userFollowData'=>$userFollow]);
            $this ->assign(['userFollowCountData'=>count($userFollow)]);
            // 获取用户粉丝
            $userFans = FollowModel::getFans($id);
            $this ->assign(['userFansData'=>$userFans]);
            $this ->assign(['userFansCountData'=>count($userFans)]);
            return view('user/user');
        }
        // 已登录
        $userId = session('user')['id'];
        $this ->assign(['userData'=>session('user')]);
        // 不是本人，显示'加关注','已关注','互相关注',用户界面
        // 获取用户关注
        $userFollow = FollowModel::queryFollower($userId,$id);
        $this ->assign(['userFollowData'=>$userFollow]);
        $this ->assign(['userFollowCountData'=>count($userFollow)]);
        // 获取用户粉丝
        $userFans = FollowModel::queryFans($userId,$id);
        $this ->assign(['userFansData'=>$userFans]);
        $this ->assign(['userFansCountData'=>count($userFans)]);
        if(session('user')['id'] != $id){
            // 用户界面

            return view('user/user');
        }

        // 已登录，是本人，显示'加关注','已关注','互相关注',用户管理后台
        if(session('user')['id'] == $id){
            // 用户后台（文章发布，修改，删除，仅能修改自己的，关注，取消关注）
            return view('user/my');
        }
    }

    // 用户上传头像，flies中只有单个文件
    public function avatar()
    {
        if(!session('?user')){
            return json(['result'=>'/static/img/avatar.jpg']);
        }
        $userId = session('user')['id'];
        // 获取裁剪数据

        $data = input('post.');
        // 字符串格式，不是关联数组
        // {"x":138.01652892561987,
        // " y":42.016528925619866,
        // " height":163.96694214876032,
        // " width":163.96694214876032,
        // " rotate":0}"
        $cutData = json_decode($data['avatar_data'],true);
        $files = request()->file();
        $imageUrl = [];
        $imageCateData = db('imagecate')->where('id', 4)->find();
        $address = $imageCateData['dir'];
        foreach ($files as $file) {
            if ($file->validate(['ext' => 'jpg,png,gif'])) {
                $image = \think\Image::open($file);
                $name = md5($file);
                $info = $image->crop($cutData['width'], $cutData['height'],$cutData['x'],$cutData['y'])
                    ->rotate($cutData['rotate'])
                    ->save(IMAGE_PATH . $address.'/'.$name.'.jpeg','jpg');
                // 判断图片是否存储成功
                if ($info) {
                    $ext = $image->type();
                    // 查询图片是否重复
                    $imageInfo = db('image')
                        ->where('imagecate_id', 4)
                        ->where('address', $name)->find();
                    // 如果没有就继续存入数据库，有就是不存
                    if (!$imageInfo) {
                        $imageId = db('image')->insertGetId([
                            'imagecate_id' => 4,
                            'address' => $name,
                            'ext' => $ext
                        ]);
                        $imageInfo = db('image')
                            ->where('id', $imageId)
                            ->find();
                    }
                    $url = '/uploads/'.$address.'/'. $imageInfo['address'].'.'.$imageInfo['ext'];
                    // 修改用户头像
                    db('users')->update(['id'=>$userId,'avatar_image_id'=>$imageInfo['id']]);
                    array_push($imageUrl,$url);
                } else {
                    // 上传失败
                    return json(['code' => -1, 'msg' => '头像上传失败']);
                }
            } else {
                // 不是图片文件
                return json(['code' => -1, 'msg' => '非法文件']);
            }
        }
        return json(['code' => 0, 'msg' => '头像上传成功', 'result' => $imageUrl]);
    }

    // 修改用户昵称
    public function nickname()
    {
        $nickName = input('post.nickname');
        $nickName = htmlentities($nickName);
        if(!session('?user')){
            return json(['code'=>-1,'msg'=>'请登录后修改']);
        }
        $userId = session('user')['id'];
        $info = UsersModel::editNickName($userId,$nickName);
        if($info){
            $nickName = UsersModel::get($userId)['nickname'];
            return json(['code'=>0,'msg'=>$nickName]);
        }else{
            return json(['code'=>-1,'msg'=>'修改昵称错误']);
        }
    }

    // 用户关注
    public function follow()
    {
        // 是否登录
        if(!session('?user')){
            return json(['code'=>-1,'msg'=>'请登录后关注']);
        }
        // 参数是否正确
        if(!isset(input('post.')['follow_user_id'])){
            return json(['code'=>-1,'msg'=>'无参数']);
        }
        $followUserId = input('post.')['follow_user_id'];
        if(!is_numeric($followUserId)){
            return json(['code'=>-1,'msg'=>'关注用户错误']);
        }
        $userId = session('user')['id'];
        $info = FollowModel::followUser($userId,$followUserId);
        return $info;
    }

}
