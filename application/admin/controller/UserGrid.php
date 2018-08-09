<?php
/**
 * 账号管理和添加
 */

namespace app\admin\controller;

use app\admin\model\f_role;
use app\admin\model\f_school;
use app\admin\model\f_user;
use app\admin\model\ref_user_role;
use think\Controller;
use think\Request;
use think\Session;

class UserGrid extends Controller {
    /**
     * 显示添加用户界面
     * @return \think\response\Json|\think\response\View
     */
    public function show() {
        $status  = 0;
        $message = '权限不够';
        $sess    = Session::get('user_info');
        if ($sess['user_name'] === 'admin') {
            return view('../application/admin/view/dialog/AddUser.html');
        }
        return json(['status' => $status, 'message' => $message]);
    }

    /**
     * 角色列表
     * @return string|\think\response\Json
     * @throws \think\exception\DbException
     */
    public function roleList() {
        $role_info = f_role::all();
        foreach ($role_info as $value){
            $role_list[] = $value->toArray();
        }
        if (!$role_info){
            return 'false';
        }
        return json($role_info);
    }

    /**
     * 检测用户名是否可用
     * @param Request $request
     * @return \think\response\Json
     */
    public function checkUserName(Request $request) {
        $userName = trim($request->param('user_name'));
        $status   = 1;
        $message  = '用户名可用';
        if (f_user::get(['user_name' => $userName])) {
            //如果在表中查询到该用户名
            $status  = 0;
            $message = '用户名重复，请重新输入';
        }
        return json(['status' => $status, 'message' => $message]);
    }

    /**
     * 检测邮箱是否可用
     * @param Request $request
     * @return \think\response\Json
     */
    public function checkUserEmail(Request $request) {
        $userEmail = trim($request->param('email'));
        $status    = 1;
        $message   = '邮箱可用';
        if (f_user::get(['email' => $userEmail])) {
            //查询表中找到了该邮箱，修改返回值
            $status  = 0;
            $message = '邮箱重复，请从新输入';
        }
        return json(['status' => $status, 'message' => $message]);
    }

    /**
     * 用户添加操作
     * @param Request $request
     * @return \think\response\Json
     */
    public function addUser(Request $request) {
        $data    = $request->param();
        $status  = 1;
        $message = '添加成功';
        $rule    = [
            'user_name|姓名' => 'require',
            'pwd|密码'       => 'require',
            'email|密码'     => 'require',
        ];

        $result = $this->validate($data, $rule);

        if ($result === true) {
            $user_data = [
                'user_name' => $data['user_name'],
                'emp_name'  => $data['emp_name'],
                'pwd'       => empty($data['pwd']) ? '' : md5($data['pwd']),
                'mobile'    => $data['mobile'],
                'email'     => $data['email'],
                'school_id' => $data['school_id'],
                'gender'    => $data['gender'],
                'desc'      => $data['des']
            ];
            $user_info = f_user::create($user_data);
            $user_id = $user_info->user_id;
            $role_data = [
                'user_id' => $user_id,
                'role_id' => $data['role_id'],
            ];
            $role_info = ref_user_role::create($role_data);
            if (!$user_info || !$role_info){
                $status  = 0;
                $message = '添加失败';
            }
        } else {
            $status  = 0;
            $message = '添加失败';
        }
        return json(['status' => $status, 'message' => $message]);
    }

    /**
     * 编辑操作有待完善
     * */
    public function updateUser(Request $request){
        $request_list = $request->param();
        $user_pwd = f_user::get($request_list['user_id'])->toArray()['pwd'];
        $request_list['pwd'] == $user_pwd ? $request_list['pwd'] == '' : $request_list['pwd'];
    }

    /**
     * 用户查询操作
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function userListData(Request $request){
        $status     = 1;
        $message    = '查询成功';
        $map        = array();

        if ($request->get('page_size')) {
            $page_size = $request->get('page_size');
        } else {
            $page_size = 10;
        }

        if ($request->get('now_page')) {
            $now_page = $request->get('now_page');
        } else {
            $now_page = 1;
        }

        $url     = $request->url();
        $url_arr = explode('&&', $url);

        if (count($url_arr) == 2) {
            $user_info = f_user::all();
            foreach ($user_info as $value) {
                $school_list    = f_school::get(['school_id' => $value['school_id']])->toArray();
                $role_id_list   = ref_user_role::get(['user_id' => $value['user_id']])->toArray();
                $role_info_list = f_role::get(['role_id' => $role_id_list['role_id']])->toArray();

                $value['school_name'] = $school_list['school_name'];
                $value['role_name']   = $role_info_list['role_name'];
                $value['role_id']     = $role_info_list['role_id'];
                $new_user_info[]      = $value->toArray();
            }
            return json(['status' => $status, 'message' => $message, 'data' => $new_user_info, 'total' => count($new_user_info)]);
        }else{
            $data_list = $request->param();
            $school_id = Session::get('user_info.user_id');

            isset($data_list['user_name']) ? $map['emp_name'] = $data_list['user_name'] : '';
            isset($data_list['mobile']) ? $map['mobile'] = $data_list['mobile'] : '';
            isset($data_list['role_id']) ? $map['role_id'] = $data_list['role_id'] : '';

            if (isset($map['emp_name']) && empty($map['role_id'])) {
                $user_info   = f_user::get(['emp_name' => $map['emp_name']]);
                $user_role   = $user_info->getRole()->select();
                $user_info   = $user_info->toArray();
                $school_list = f_school::get(['school_id' => $user_info['school_id']])->toArray();

                foreach ($user_role as $value) {
                    $user_role = $value->toArray();
                }
                $user_info['role_id']     = $user_role['role_id'];
                $user_info['role_name']   = $user_role['role_name'];
                $user_info['school_name'] = $school_list['school_name'];
                $new_user_role            = $user_info;
                return json(['status' => $status, 'message' => $message, 'data' => $new_user_role, 'total' => count($new_user_role)]);
            } elseif (isset($map['role_id']) && empty($map['user_name'])) {
                $role_info = f_role::get(['role_id' => $map['role_id']]);
                $role_user = $role_info->getUser()->select();
                $role_info = $role_info->toArray();

                foreach ($role_user as $value) {
                    $user_info                = $value->toArray();
                    $school_list              = f_school::get(['school_id' => $user_info['school_id']]);
                    $user_info['school_name'] = $school_list['school_name'];
                    $user_info['role_id']     = $role_info['role_id'];
                    $user_info['role_name']   = $role_info['role_name'];
                    $new_user_role[]          = $user_info;
                }
                return json(['status' => $status, 'message' => $message, 'data' => $new_user_role, 'total' => count($new_user_role)]);
            }
        }
    }
}