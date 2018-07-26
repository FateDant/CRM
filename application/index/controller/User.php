<?php

namespace app\index\controller;

use app\index\model\User as UserModel;
use lib\Email;
use think\Request;
use think\Session;

/**
 * 用户模块（登录、找回密码）
 */
class User extends Base {
    //1.显示登录用户的界面
    public function registerAction() {
        $this->alreadyLogin(); //防止重复登录
        return $this->view->fetch();
    }

    //2.验证登录
    public function checkLogin(Request $request) {
        $status = 0; //初始化验证失败标志
        $result = '验证失败'; //初始化失败提示信息
        $data   = $request->param();  //获取表单信息
        //验证规则
        $rule = [
            'name|姓名'     => 'require',
            'password|密码' => 'require',
            'captcha|验证码' => 'require|captcha'
        ];

        //验证数据 $this->validate($data, $rule, $msg)
        $result = $this->validate($data, $rule);

        //通过验证后,进行数据表查询
        //此处必须全等===才可以,因为验证不通过,$result保存错误信息字符串,返回非零
        if (true === $result) {

            //查询条件
            $map = [
                'user_name' => $data['name'],
                'pwd'       => md5($data['password'])
            ];

            //数据表查询,返回模型对象
            $user = UserModel::get($map);
            if (null === $user) {
                $result = '用户名或密码错误，请检查';
            } else {
                $status = 7;
                $result = '验证通过,点击[确定]后进入后台';

                //设置用户登录注销用：session
                Session::set('user_id', $user->user_id);  //用户ID
                Session::set('user_info', $user->getData()); //用户所有信息
            }
        }

        return json(['status' => $status, 'message' => $result, 'data' => $data]);
    }

    //3.找回密码
    public function forgotPassword() {
        return $this->view->fetch();
    }

    //4.接收邮箱并发送密码
    public function sendPassword(Request $request) {
        $status = 0; //验证失败标志
        $result = '验证失败'; //失败提示信息
        $data   = $request->param();
        //TODO
        $data['email'] = '1332836872@qq.com';
        //验证规则
        $rule   = [
            'email|邮箱' => 'require'
        ];
        $result = $this->validate($data, $rule);
        //通过验证后,进行数据表查询
        //此处必须全等===才可以,因为验证不通过,$result保存错误信息字符串,返回非零
        if (true === $result) {
            //查询条件
            $map = [
                'email' => $data['email'],
            ];


            //数据表查询,返回模型对象
            $user = UserModel::get($map);
            if (null === $user) {
                $result = '邮箱不存再，请检查';
            } else {
                //根据邮箱查找用户信息并更新密码
                $userMessage = $user->showDate();
                //发送邮件
                $title   = '找回密码';
                $rand    = rand(100000, 999999);
                $content = '用户名是' . "{$userMessage['user_name']}" . "\n" . '密码是' . "$rand";
                $getter  = $userMessage['email'];
                $email   = new Email();
                if ($email->send($title, $content, $getter)) {
                    $result = '邮件已发送，请查收';
                    $status = 7;
                    //将密码更新到数据库
                    var_dump($content);
                    $user->pwd = md5($rand);
                    $user->save();
                } else {
                    $result = '邮件发送失败';
                }
            }
        }
        var_dump($content);
        return json(['status' => $status, 'message' => $result, 'data' => $data]);
    }

    //5.退出登录
    public function Logout() {
        Session::delete('user_id');
        Session::delete('user_info');
        $this->success('注销登录，正在返回', 'user/registerAction');
    }

    //6.重新登录
    public function Logagain() {
        Session::delete('user_id');
        Session::delete('user_info');
        $this->success('重新登录', 'user/registerAction');
    }
}