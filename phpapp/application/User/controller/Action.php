<?php
namespace app\user\controller;

use app\admin\model\Cate as CateModel;
use app\admin\model\Blog as BlogModel;
use app\admin\model\Comments as CommentsModel;
//require_once (EXTEND_PATH.'Htmlpurifier\HTMLPurifier.auto.php');
class Action extends UserBase
{
    public function _initialize()
    {
        parent::_initialize();
//        $config = HTMLPurifier_Config :: createDefault();
//        $purifier = new HTMLPurifier($config);
//        echo $purifier->version;die;
        // 是否登录
        if(!session('?user')){
            $this->redirect('/');
        }
    }

    // 创建文章，get获取输入框，post存储内容，防xss
    public function add()
    {
        if (request()->isGet()) {
            $cateList = CateModel::getCateList();
            return view('action/add',['cateData'=>$cateList]);
        }
        if (request()->isPost()) {
            $data = input('post.');
            // 构造数据
            $blogdata = [];
            $blogdata['blog_title'] =$data['blog_title'];
            $blogdata['cate_id'] =$data['cate'];
            // 处理主图id
            $blogdata['image_id'] =substr($data['master_image'], 0, -1);
            $blogdata['unique_tag'] =$data['unique_tag'];
            $blogdata['blog_html'] =$data['edit-html'];
            $blogdata['blog_text'] =$data['edit-text'];
            // 标记状态为未审核
            $blogdata['blog_status'] = 0;
            $tagData = [$data['tag-origin'],$data['tag-level']];
            // 防xss，mysql_escape_string(),htmlspecialchars()
//            foreach ($data as $k=>$v){
//                if($k != 'edit-html'){
//                    $data[$k] = htmlspecialchars($v,ENT_QUOTES);
//                }
//            }
            // 写入user_id
            $userId = session('user')['id'];
            $blogdata['user_id'] = $userId;
            $newData = ['blogdata'=>$blogdata,'tagdata'=>$tagData];
            $info = Blogmodel::createBlog($newData);
            if($info){
                $this->redirect('/user?id='.$userId);
            }else{
                $this->redirect('/user?id='.$userId);
            }
        }
    }

    // 修改文章，get获取内容，post修改内容，防xss
    public function edit($id=1)
    {
        $userId = session('user')['id'];
        if (request()->isGet()) {
            // 文章是否存在,是否属于登录者
            $preEditBlog = Blogmodel::get($id);
            if(!$preEditBlog || ($preEditBlog['user_id'] !== $userId)) {
                $this->redirect('/user?id=' . $userId);
            }
            $cateList = CateModel::getCateList();
            $this->assign('cateData',$cateList);
            $blogData = Blogmodel::queryBlog($id);
            if($blogData['code'] == 0){
                $this->assign('blogData',$blogData['data']);
                return view('action/edit');
            }else{
                $this->redirect('/user?id='.$userId);
            }
        }
        if (request()->isPost()) {
            $data = input('post.');
            // 文章是否存在,是否属于登录者
            $preEditBlog = Blogmodel::get($data['id']);
            if(!$preEditBlog || ($preEditBlog['user_id'] !== $userId)) {
                $this->redirect('/user?id=' . $userId);
            }
            // 构造数据
            $blogdata = [];
            $blogdata['id'] = $data['id'];
            $blogdata['blog_title'] = $data['blog_title'];
            $blogdata['cate_id'] = $data['cate'];
            // 处理主图id
            $blogdata['image_id'] = substr($data['master_image'], 0, -1);
            $blogdata['unique_tag'] = $data['unique_tag'];
            $blogdata['blog_html'] = $data['edit-html'];
            $blogdata['blog_text'] = $data['edit-text'];
            // 标记状态为未审核
            $blogdata['blog_status'] = 0;
            $tagData = [$data['tag-origin'],$data['tag-level']];
            // 安全验证，mysql_escape_string(),htmlspecialchars()
//            foreach ($data as $k=>$v){
//                if($k != 'edit-html'){
//                    $data[$k] = htmlspecialchars($v,ENT_QUOTES);
//                }
//            }
            // 写入user_id
            $blogdata['user_id'] = $userId;
            $newData = ['blogdata'=>$blogdata,'tagdata'=>$tagData];
            $info = Blogmodel::editBlog($newData);
            if($info){
                $this->redirect('/user?id='.$userId);
            }else{
                $this->redirect('/user?id='.$userId);
            }
        }
    }

    // 删除文章
    public function deleteBlog()
    {
        $userId = session('user')['id'];
        $id = input('post.')['id'];
        // 文章是否存在,是否属于登录者
        $preDeleteBlog = Blogmodel::get($id);
        if(!$preDeleteBlog || ($preDeleteBlog['user_id'] !== $userId)) {
            return json(['code'=>-1,'msg'=>'文章不存在']);
        }
        // 只删除博客，删除博客收藏，不删除博客下的评论及回复
        $info = Blogmodel::destroy(['id'=>$id]);
        db('favorite')->where('blog_id',$id)->delete();
        if($info){
            return json(['code'=>0,'msg'=>'文章已删除']);
        }else{
            return json(['code'=>0,'msg'=>'删除失败']);
        }
    }
    // 删除评论，不删除回复
    public function deleteComment()
    {
        $userId = session('user')['id'];
        $id = input('post.')['id'];
        // 评论是否存在,是否属于登录者
        $preDeleteComment = CommentsModel::get($id);
        if(!$preDeleteComment || ($preDeleteComment['user_id'] !== $userId)) {
            return json(['code'=>-1,'msg'=>'评论不存在']);
        }
        // 只删除评论，不删除评论的回复
        $info = CommentsModel::destroy(['id'=>$id]);
        if($info){
            return json(['code'=>0,'msg'=>'评论已删除']);
        }else{
            return json(['code'=>0,'msg'=>'删除失败']);
        }
    }
}
