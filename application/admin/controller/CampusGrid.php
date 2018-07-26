<?php
/**
 * 校区招生
 */

namespace app\admin\controller;

use app\admin\model\AddStu;
use app\admin\model\Course as CourserModel;
use app\admin\model\UserRight as UserRightModel;
use app\admin\model\User as UserModel;
use app\admin\model\UserRight;
use think\Controller;
use app\admin\model\CampusGrid as CampusGridModel;
use think\Request;
use think\Session;

class CampusGrid extends Controller {
    public function index() {
        return view('../application/admin/view/grid/CampusGrid.html');
    }

    //获取渠道数据
    public function channel() {
        $channelInfo = CampusGridModel::all(['channel_category' => '校区招生']);
        if (!$channelInfo) {
            $message = '没有数据';
            return $message;
        }
        foreach ($channelInfo as $key => $value) {
            $data[] = $value->toArray();
        }
        //返回常规招生的数组
        return json($data);
    }

    //添加学生信息
    public function addStudent(Request $request) {
        $data    = $request->param();
        $status  = 1;
        $message = '添加成功';
        $rule    = [
            'student_name|学生姓名' => 'require',
        ];
        $result  = $this->validate($data, $rule);


        //验证通过
        if ($result === true) {
            $status  = 1;            //初始化
            $message = '添加成功';   //初始化
            //获取创建者、更新者
            $user_id                  = Session::get('user_info.user_id');
            $data['create_id']        = $user_id;
            $data['last_update_id']   = $user_id;
            $data['first_visit_time'] = date('Y-m-d H:i:s', strtotime($data['first_visit_time']));
            $data['register_time']    = date('Y-m-d H:i:s', strtotime($data['register_time']));

            $gender                = array('女', '男', '保密');
            $data['gender']        = $gender[$data['gender']];
            $education             = array('初中', '中专', '高中', '高职', '大专', '本科生', '研究生');
            $data['education']     = $education[$data['education']];
            $currentState          = array('在读学校', '在读离校', '待业', '在职', '自由职业');
            $data['current_state'] = $currentState[$data['current_state']];
            $visitState            = array('未上门', '已上门', '已报名');
            $data['visit_state']   = $visitState[$data['visit_state']];
            //TODO
            $data['school_id'] = 1;
            $user              = AddStu::create($data);

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

    //显示添加信息表单
    public function show() {
        return view('../application/admin/view/dialog/AddStu.html');
    }

    //获取课程数据
    public function course() {
        $courseInfo = CourserModel::all();
        if (!$courseInfo) {
            $message = '没有数据';
            return $message;
        }
        foreach ($courseInfo as $key => $value) {
            $data[] = $value->toArray();
        }
        return json($data);
    }

    //在线咨询数据
    public function onlineConsultant() {
        $onlineConsultantInfo = UserRightModel::all(['role_id' => 4]);
        if (!$onlineConsultantInfo) {
            $message = '没有数据';
            return $message;
        }
        foreach ($onlineConsultantInfo as $key => $value) {
            $a[] = $value->toArray()['user_id'];
        }

        $userInfo = UserModel::all($a);
        if (!$onlineConsultantInfo) {
            $message = '没有数据';
            return $message;
        }
        foreach ($userInfo as $key => $value) {
            $data[] = $value->toArray();
        }
        return json($data);
    }

    //课程顾问数据
    public function courseConsultant() {
        $courseConsultant = UserRightModel::all(['role_id' => 5]);
        if (!$courseConsultant) {
            $message = '没有数据';
            return $message;
        }
        foreach ($courseConsultant as $key => $value) {
            $a[] = $value->toArray()['user_id'];
        }

        $userInfo = UserModel::all($a);
        if (!$userInfo) {
            $message = '没有数据';
            return $message;
        }
        foreach ($userInfo as $key => $value) {
            $data[] = $value->toArray();
        }
        return json($data);
    }

    //学生信息查询
    public function stuInfo(Request $request) {
        $status = 1;
        $message = '查询成功';

//        $list = AddStu::all();
//        foreach ($list as $key => $value){
//            $data[] = $value -> toArray();
//        }
        $data = $request->param();
        $userInfo[] = AddStu::all(['student_name' => $data['student_name']]);
        var_dump($userInfo);die;




//        $status   = 1;
//        $message  = '查询成功';
//        $data     = $request->param();
//        $userInfo = UserModel::get(['user_name' => $data['user_name']]);
//        if ($userInfo == null) {
//            $status  = 0;
//            $message = '数据不存在';
//        } else {
//            $data = UserModel::get(['user_name' => $data['user_name']])->toArray();
//        }
//        return json(['status' => $status, 'message' => $message, 'data' => $data]);
    }



}