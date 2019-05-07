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
    // 查询权限
    public function queryAuthRule($page=1, $limit=10)
    {
        $authRuleData = AuthRuleModel::getAuthRuleList();
        // 按页码截断数组,分页显示
        $data = array_slice($authRuleData,($page-1)*$limit,$limit);
        foreach($data as $k=>$v){
            // 添加分级前缀，便于前端显示
            $v['p_title'] = str_repeat('- - ',$v['level']).$v['title'];
            // 获取pid的分类名称
            $v['pid_name'] = $this->authRule[$v['pid']];
        }
        return json(["code"=>0, "msg"=>"查询成功", "count"=>$this->count,"data"=>$data]);
    }

    // 增加权限
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

    // 修改权限，只支持修改权限名，权限标识，不支持修改状态，级别
    public function editAuthRule()
    {
        $data = input('post.');
        $info = AuthRuleModel::editAuthRule($data);
        if($info){
            return json(['code'=>0, 'msg'=>'权限修改成功']);
        }
    }

    // 删除权限，同时删除子权限，更新auth_group表中权限
    public function deleteAuthRule()
    {
        $id = input('post.')['id'];
        $auth = new AuthRuleModel();
        $pDelAuth = $auth -> getChildrenId($id);
        $pDelAuth[] = $id;
        // 删除用户组表中rules字段所有已删除权限，
        $authGroupRuleData = db('auth_group')
            ->column('rules','id');
        // 遍历每个待删除的权限，$value 单个权限
        foreach ($pDelAuth as $value){
            // 待删除权限和每个用户组作比较，$k 用户组id，$v 权限组权限
            foreach($authGroupRuleData as $k=>$v){
                // 如果用户组里有权限就更新权限
                $rulesArr = explode(',',$v);
                if(in_array($value,$rulesArr)){
                    // 删除数组中已被删除的权限
                    $newRulesArr = array_diff($rulesArr ,[$value]);
                    // 把数组转为权限格式 , , ,
                    $ruleStr = implode(',',$newRulesArr);
                    $ruleInfo = db('auth_group')
                        -> where('id', $k)
                        -> update(['rules' => $ruleStr]);
                }
            }
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
        $rulesData = db('auth_rule')->field('id,title')->select();
        foreach ($rulesData as $k=>$v){
            $rulesDataArr[$v['id']] = $v['title'];
        }
        // 构造前端所需数据
        foreach($data as $k=>$v){
            // 添加分级前缀，便于前端显示
            $v['p_title'] = str_repeat('- - ',$v['level']).$v['title'];
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

    // 修改用户组，只支持修改用户组名称
    public function editAuthGroup()
    {
        $data = input('post.');
        $info = AuthGroupModel::editAuthGroup($data);
        if($info){
            return json(['code'=>0,'msg'=>'编辑用户组成功']);
        }
    }

    // 删除用户组，下级用户组也会删除，对应用户也会取消用户组
    public function deleteAuthGroup()
    {
        $id = input('post.')['id'];
        $authGroup = new AuthGroupModel();
        $pDelAuthGroup = $authGroup ->getChildrenId($id);
        $pDelAuthGroup[] = $id;
        $info = AuthGroupModel::destroy($pDelAuthGroup);
        // 修改auth_group_access，删除用户组下的所有用户删除权限
        $groupAccessInfo = 0;
        if($info){
            foreach ($pDelAuthGroup as $value){
                $groupAccessInfo = $groupAccessInfo + db('auth_group_access')
                    -> where('group_id', $value)
                    -> delete();
            }
        }
        if($info){
            return json(['code'=>0,
                'msg'=>'删除用户组成功，影响'.$groupAccessInfo.'个用户'
            ]);
        }
    }

/************************用户管理************************/
    // 查询用户
    public function queryUser($page=1,$limit=10)
    {
        $data = UsersModel::getUsersList($page,$limit);
        // 添加显示用户的所属用户组
        // 查出用户组id-title对应值
        $authGroupData = db('auth_group')
                        -> column('title','id');
        // 查询用户-用户组关联表，寻找此用户所有用户组id
        foreach($data as $value){
            $groupAccessData = db('auth_group_access')
                -> where('uid',$value['id'])
                -> select();
            // 查出用户组id后再查出用户组title
            $groupTitle = '';
            foreach ($groupAccessData as $group){
                // 出现为0的情况是添加用户时没有用户组供选择
                if($group['group_id'] == 0){
                    $groupTitle = '添加此用户时没有用户组';
                }else {
                    $groupTitle = $groupTitle.$authGroupData[$group['group_id']].' | ';
                }
            }
            $value['group_title'] = $groupTitle;
        }
        $count = UsersModel::count();
        return json(["code"=>0,
            "msg"=>"查询成功",
            'count'=>$count,
            "data"=>$data
            ]);
    }

    /* 添加用户
     * 把用户添加到用户组
     */
    public function addUser()
    {
        $data = input('post.');
        $userData = passWordMd5($data['account']);
        // 判断账号是否存在
        // pass
        $info = UsersModel::createUsers($userData);
        // 写入用户-用户组关联数据
        if($info){
            // 判断提交的用户组是否存在
            // pass
            $authAccessData = $data['piddata']['pid'];
            $authAccessArr = explode(',',$authAccessData);
            $uidAuthAccessData = [];
            foreach ($authAccessArr as $value){
                $uidAuthAccessData[] = ['uid'=>$info['id'],'group_id'=>$value];
            }
            $accessInfo = db('auth_group_access')
                ->insertAll($uidAuthAccessData);
        }else{
            $accessInfo = false;
        }
        if($info && $accessInfo){
            return json(['code'=>0, 'msg'=>'增加用户成功']);
        }else{
            return json(['code'=>-1, 'msg'=>'增加用户失败']);
        }
    }

    /* 修改用户账号和密码和昵称
     * 暂不支持修改用户组
     */
    public function editUser()
    {
        $data = input('post.');
        // 传递的密码为空时不编辑密码
        // pass
        $data = passWordMd5($data);
        $info = UsersModel::editUsers($data);
        if($info){
            return json(["code"=>0,"msg"=>"编辑用户成功"]);
        }else{
            return json(["code"=>-1,"msg"=>"编辑用户失败"]);
        }
    }

    /* 删除用户，同时(auth_group_access)中user_id也应删除，
     * 重置所有文章为user_id为1
     * 删除用户所有评论
     * 清除对应session
     */
    public function deleteUser()
    {
        $id = input('post.')['id'];
        if((session('user')['id'] == $id) || ($id == 1)){
            return json(["code"=>-1,"msg"=>"无法删除本身或管理员"]);
        }
        $info = UsersModel::deleteUsers($id);
        // 删除用户-用户组表数据，删除评论，重置文章
        if($info){
            $accessInfo = Db('auth_group_access')
                ->where('uid',$id)
                ->delete();
            $commentInfo = Db('comments')
                ->where('user_id',$id)
                ->delete();
            $blogInfo = Db('blog')
                ->where('user_id',$id)
                ->update(['user_id' => 1]);
        }else{
            $accessInfo = $commentInfo = $blogInfo =  false;
        }
        // 清除Session
        // pass
        if($info){
            return json(["code"=>0,"msg"=>"删除用户成功"]);
        }
    }
}