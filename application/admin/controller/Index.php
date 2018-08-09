<?php
/**
 * 首页总览
 */

namespace app\admin\controller;


use app\admin\model\f_role;
use app\admin\model\ref_user_role;
use app\index\controller\Base;
use think\Session;


class Index extends Base {
    public function index() {
        $this->isLogin(); //判断用户是否登录
        return $this->view->fetch();
    }

    public function Privilege() {
        $status = 1;
        $message = '查询成功';
        //获取用户id
        $user_id = Session::get('user_info.user_id');

        //根据用户id查找用户角色id
        $role_id   = ref_user_role::get($user_id)->toArray()['role_id'];
        $role_info = f_role::get($role_id);
        $role_priv = $role_info->getPriv()->select();

        if (!$role_priv){
            $status = 0;
            $message = '查询失败';
            return json(['status' => $status, 'message' => $message]);
        }

        foreach ($role_priv as $value) {
            $priv_info[] = $value->toArray();
        }
        foreach ($priv_info as $value) {
            $priv_list[] = $value['priv_name'];
        }

        $api = [
            '总部查询'     => 'CollegeGrid/stuListData?id=1&&',
            '校区查询'     => 'CollegeGrid/schoolList',
            '校区学生信息录入' => 'CollegeGrid/addStudent',
            '校区学生信息查询' => 'CollegeGrid/stuListData',
            '校区学生信息编辑' => 'CollegeGrid/updateStudentAction',
            '用户信息修改'   => 'UserGrid/updateUser',
            '用户信息增加'   => 'UserGrid/addUser',
            '用户信息查询'   => 'UserGrid/userListData',
            '回访记录增加'   => 'CollegeGrid/addCallBack',
            '回访记录查询'   => 'CollegeGrid/selectRevisitData',
            '数据统计图表'   => 'IndexCharts/index'
        ];

        foreach ($priv_list as $value) {
            if (array_key_exists($value, $api)) {
                $api_info = $api[$value];
            }
            $api_list['priv_name'] = $value;
            $api_list['priv_url']  = $api_info;
            $new_api_list[]        = $api_list;
        }
        return json(['status' => $status, 'message' => $message, 'data' => $new_api_list,'total' => count($new_api_list)]);
    }
}
