<?php
namespace app\Search\controller;

use app\admin\model\Blog;
use app\blog\controller\Base;
use app\admin\model\Blog as BlogModel;
use app\admin\model\Users as UsersModel;
use app\admin\model\Follow as FollowModel;
class Index extends Base
{
    public function index($c = 1 , $q = '',$start=1,$end=1)
    {
        $q = htmlspecialchars($q);
        if(!(is_numeric($start)&&is_numeric($end))){
            $this->redirect('/search');
        }
        $this->assign('c',$c);
        $this->assign('q',$q);
        $this->assign('cateData',[1=>'文章',2=>'标签',3=>'用户']);
        switch ($c)
        {
            // 文章搜索，仅在文章搜索可以使用
            case 1:
                if(($end-$start)==0){
                    // 不带时间查
                    $searchBlog = BlogModel::searchBlog($q);
                }else{
                    // 带时间查
                    $searchBlog = BlogModel::searchTimeBlog($q,$start,$end);
                }
                $searchBlogCount = count($searchBlog);
                $this->assign('searchBlogCountData',$searchBlogCount);
                $this->assign('searchBlogData',$searchBlog);
                return view('index/article');
                break;
            // 标签搜索
            case 2:
                $searchTag = BlogModel::searchTag($q);
                $searchTagCount = count($searchTag);
                $this->assign('searchTagData',$searchTag);
                $this->assign('searchTagCountData',$searchTagCount);
                return view('index/tag');
            // 用户搜索
            case 3:
                $searchUsers = UsersModel::searchUsers($q);
                $this->assign('searchUsersCountData',count($searchUsers));
                if(session('?user')){
                    // 已登录，判断关注状态
                    $viewerId = session('user')['id'];
                    foreach ($searchUsers as $k){
                        $k['follow_status'] = FollowModel::queryStatus($viewerId,$k['id']);
                    }
                    $this->assign('searchUsersData',$searchUsers);
                    $this->assign('userLoginStatusData',1);
                }else{
                    // 未登录
                    $this->assign('searchUsersData',$searchUsers);
                    $this->assign('userLoginStatusData',0);
                }
                return view('index/user');
            default:
                $this->redirect('/');
        }
    }
}
