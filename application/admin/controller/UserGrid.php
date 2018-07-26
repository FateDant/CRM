<?php
/**
 * 账号管理和添加
 */

namespace app\admin\controller;

use app\admin\model\User as UserModel;
use app\admin\model\User;
use think\Controller;
use think\Request;
use think\Session;

class UserGrid extends Controller {
    public function index() {
        return view('../application/admin/view/grid/UserGrid.html');
    }

    //显示添加用户页面
    public function show() {
        $status  = 0;
        $message = '权限不够';
        $sess    = Session::get('user_info');
        if ($sess['user_name'] === 'admin') {
            return view('../application/admin/view/dialog/AddUser.html');
        }
        return json(['status' => $status, 'message' => $message]);
    }

    //检测用户名是否可用
    public function checkUserName(Request $request) {
        $userName = trim($request->param('user_name'));
        $status   = 1;
        $message  = '用户名可用';
        if (UserModel::get(['user_name' => $userName])) {
            //如果在表中查询到该用户名
            $status  = 0;
            $message = '用户名重复，请重新输入';
        }
        return json(['status' => $status, 'message' => $message]);
    }

    //检测用户邮箱是否可用
    public function checkUserEmail(Request $request) {
        $userEmail = trim($request->param('email'));
        $status    = 1;
        $message   = '邮箱可用';
        if (UserModel::get(['email' => $userEmail])) {
            //查询表中找到了该邮箱，修改返回值
            $status  = 0;
            $message = '邮箱重复，请从新输入';
        }
        return json(['status' => $status, 'message' => $message]);
    }

    //添加操作
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

        $newData = [
            'user_name' => $data['user_name'],
            'emp_name'  => $data['emp_name'],
            'pwd'       => empty($data['pwd']) ? '' : md5($data['pwd']),
            'mobile'    => $data['mobile'],
            'email'     => $data['email'],
            'school_id' => 1
        ];

        if ($result === true) {
            $user = UserModel::create($newData);
            if ($user == null) {
                $status  = 0;
                $message = '添加失败';
            }
        } else {
            $status  = 0;
            $message = '添加失败';
        }
        return json(['status' => $status, 'message' => $message]);
    }

    //查询操作
    public function selectUser(Request $request) {
        $status   = 1;
        $message  = '查询成功';
        $data     = $request->param();
        $userInfo = UserModel::get(['user_name' => $data['user_name']]);
        if ($userInfo == null) {
            $status  = 0;
            $message = '数据不存在';
        } else {
            $data = UserModel::get(['user_name' => $data['user_name']])->toArray();
        }
        return json(['status' => $status, 'message' => $message, 'data' => $data]);


    }
}