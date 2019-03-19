<?php
namespace app\admin\controller;

use think\Db;
use app\admin\model\Users as UsersModel;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\model\AuthGroupAccess as AuthGroupAccessModel;

class Auth extends Base
{
    protected $authRule;
    protected $count;

    function _initialize()
    {
        parent::_initialize();
        $data = AuthRuleModel::select();
        foreach ($data as $k=>$v){
            $this->authRule[$v['id']] = $v['title'];
        }
        $this->authRule[0] = '顶级权限';
        $this->count = count($this->authRule)-1;
    }

    public function index()
    {
        $authRuleTreeData = AuthRuleModel::getAuthRuleList();
        $authGroupTreeData = AuthGroupModel::getAuthGroupList();
        return view('auth/auth',[
            'authrules'=>$authRuleTreeData,
            'authgroups'=>$authGroupTreeData
        ]);
    }

/************************权限管理************************/
    // 权限查询
    public function queryAuthRule($page=1, $limit=10)
    {
        $authRuleData = AuthRuleModel::getAuthRuleList();
        // 按页码截断数组,分页显示
        $data = array_slice($authRuleData,($page-1)*$limit,$limit);
        foreach($data as $k=>$v){
            // 添加分级前缀，便于前端显示
            $v['p_title'] = str_repeat('--',$v['level']).$v['title'];
            // 获取pid的分类名称
            $v['pid_name'] = $this->authRule[$v['pid']];
        }
        return json(["code"=>0, "msg"=>"查询成功", "count"=>$this->count,"data"=>$data]);
    }

    // 权限增加
    public function addAuthRule()
    {
        $data = input('post.');
        // 写入权限等级
        if($data['pid'] == 0){
            $data['level'] = 0;
        }else{
            $parentLevel = Db('auth_rule')
                ->where('id',$data['pid'])
                ->field('level')
                ->find();
            $data['level'] = $parentLevel['level'] + 1;
        }
        $info = AuthRuleModel::createAuthRule($data);
        if($info){
            // return json(['code'=>0,'msg'=>'添加权限成功']);
            $this->redirect('/admin/auth');
        }else{
            return '<span style="color:red;">系统错误 </span><a href="/admin/auth">点击返回</a>';
        }
    }

    // 权限修改
    public function editAuthRule()
    {
        $data = input('post.');
        $info = AuthRule::editAuthRule($data);
        if($info){
            return json(['code'=>0, 'msg'=>'权限修改成功']);
        }
    }

    // 删除权限，同时删除子权限，删除auth_group表中权限
    public function deleteAuthRule()
    {
        $id = input('post.')['id'];
        $auth = new AuthRuleModel();
        $pDelAuth = $auth -> getChildrenId($id);
        $pDelAuth[] = $id;
        // 删除auth_group表中rules字段所有已删除权限
        foreach ($pDelAuth as $value){
            //pass
        }
        // 删除权限和子权限
        $info = AuthRuleModel::destroy($pDelAuth);
        if($info){
            return json(['code'=>0, 'msg'=>$info.'个权限删除成功']);
        }else{
            return json(['code'=>-1, 'msg'=>'删除失败']);
        }
    }

/************************用户组管理************************/
    // 用户组查询
    public function queryAuthGroup($page=1, $limit=10)
    {
        $authGroupData = AuthGroupModel::getAuthGroupList();
        $data = array_slice($authGroupData,($page-1)*$limit,$limit);
        // 获取id，权限名对应的关联数组
        $rulesDataArr = [];
        $rulesData = Db('auth_rule')->field('id,title')->select();
        foreach ($rulesData as $k=>$v){
            $rulesDataArr[$v['id']] = $v['title'];
        }
        // 构造前端所需数据
        foreach($data as $k=>$v){
            // 添加分级前缀，便于前端显示
            $v['p_title'] = str_repeat('--',$v['level']).$v['title'];
            // 获取用户组的权限，把n,n,n转为对应的权限名称并显示
            $rulesArr = explode(',',$v['rules']);
            $v['rules_title'] = '';
            if(count($rulesArr)>0 && ($rulesArr[0]!= '')) {
                foreach ($rulesArr as $value) {
                    $v['rules_title'] = $v['rules_title'] . $rulesDataArr[$value] . ' | ';
                }
            }else {
                $v['rules_title'] = '无权限';
            }
        }
        return json(["code"=>0, "msg"=>"查询成功", "count"=>count($data),"data"=>$data]);
    }

    // 用户组增加，并分配权限，选择下级权限自动添加上级权限
    public function addAuthGroup()
    {
        $data = input('post.');
        // 自动拥有上级权限
        // pass
        $info = AuthGroupModel::createAuthGroup($data);
        if($info){
            return json(['code'=>0, 'msg'=>'用户组添加成功']);
        }
    }

    // 修改用户组，修改权限-用户组表，属于用户组的用户会自动修改权限
    public function editAuthGroup()
    {
        $data = input('post.');
        $info = AuthGroupModel::editAuthGroup($data);
        if($info){
            return json(['code'=>0,'msg'=>'编辑用户组成功']);
        }
    }

    // 删除用户组，下级用户组也会删除，所有删除的组内用户重置为默认用户（auth_group_access表）
    public function deleteAuthGroup()
    {
        $id = input('post.')['id'];
        $info = AuthGroupModel::deleteAuthGroup($id);
        // 重置为默认用户
        // pass
        if($info){
            return json(['code'=>0,'msg'=>'删除用户组成功']);
        }
    }

/************************用户管理************************/
    // 查询用户
    public function queryUser($page=1,$limit=10)
    {
        $data = UsersModel::getUsersList($page,$limit);
        return json(["code"=>0,
            "msg"=>"查询成功",
            'count'=>count($data),
            "data"=>$data]
        );
    }

    // 添加用户
    public function addUser()
    {
        $data = input('post.');
        $data = passWordMd5($data);
        $info = UsersModel::createUsers($data);
        if($info){
            return json(['code'=>0, 'msg'=>'增加用户成功']);
        }else{
            return json(['code'=>-1, 'msg'=>'增加用户失败']);
        }
    }

    // 修改用户
    public function editUser()
    {
        $data = input('post.');
        $data = passWordMd5($data);
        $info = UsersModel::editUsers($data);
        if($info){
            return json(["code"=>0,"msg"=>"编辑用户成功"]);
        }else{
            return json(["code"=>-1,"msg"=>"编辑用户失败"]);
        }
    }

    // 删除用户，同时(auth_group_access)中也应删除，重置所有文章为user_id为1，删除所有评论
    public function deleteUser()
    {
        $id = input('post.')['id'];
        $info = UsersModel::deleteUsers($id);
        if($info){
            // 重置博客，删除评论
        }
        if($info){
            return json(["code"=>0,"msg"=>"删除用户成功"]);
        }
    }
}