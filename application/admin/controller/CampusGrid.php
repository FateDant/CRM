<?php
/**
 * 校区招生
 */

namespace app\admin\controller;

use app\admin\model\f_channel;
use app\admin\model\f_course;
use app\admin\model\f_school;
use app\admin\model\f_student;
use app\admin\model\f_user;
use app\admin\model\log_visit;
use app\admin\model\ref_user_role;
use think\Controller;
use think\Request;
use think\Session;

class CampusGrid extends Controller {
    /**
     * 显示校区
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function index() {
        $status  = 1;
        $message = '查询成功';

        //从Session中获取学校id
        $school_id  = Session::get('user_info.school_id');
        $schoolInfo = f_school::get($school_id)->toArray();

        if (!$schoolInfo) {
            $status  = 0;
            $message = '查询失败';
            return json(['status' => $status, 'message' => $message]);
        }

        $school_name = $schoolInfo['school_name'];
//        return json(['status' => $status, 'message' => $message, 'data' => $school_name, 'total' => 1]);
        $this->assign('school_name', $school_name);
        return view('../application/admin/view/grid/CampusGrid.html');
    }

    /**
     * 显示校区招生下拉列表
     * @return string|\think\response\Json
     * @throws \think\exception\DbException
     */
    public function channel() {
        $status  = 1;
        $message = '查询成功';
        $data    = array();

        $channelInfo = f_channel::all(['channel_category' => '校区招生']);
        if (!$channelInfo) {
            $status  = 0;
            $message = '查询失败';
            return json(['status' => $status, 'message' => $message]);
        }

        foreach ($channelInfo as $key => $value) {
            $data[] = $value->toArray();
        }
        return json(['status' => $status, 'message' => $message, 'data' => $data, 'total' => count($channelInfo)]);
    }

    /**
     * 学生信息的添加
     * @param Request $request
     * @return \think\response\Json
     */
    public function addStudent(Request $request) {
        $status  = 1;
        $message = '添加成功';

        $data = $request->param();

        //验证信息
        $rule   = [
            'student_name|学生姓名' => 'require',
        ];
        $result = $this->validate($data, $rule);

        //验证通过
        if ($result === true) {
            //获取创建者、更新者
            $user_id                  = Session::get('user_info.user_id');
            $data['create_id']        = $user_id;
            $data['last_update_id']   = $user_id;
            $data['first_visit_time'] = date('Y-m-d H:i:s', strtotime($data['first_visit_time']));
            $data['register_time']    = date('Y-m-d H:i:s', strtotime($data['register_time']));
            $gender                   = array('女', '男', '保密');
            $data['gender']           = $gender[$data['gender']];
            $education                = array('初中', '中专', '高中', '高职', '大专', '本科生', '研究生');
            $data['education']        = $education[$data['education']];
            $currentState             = array('在读学校', '在读离校', '待业', '在职', '自由职业');
            $data['current_state']    = $currentState[$data['current_state']];
            $visitState               = array('未上门', '已上门', '已报名');
            $data['visit_state']      = $visitState[$data['visit_state']];
            $data['school_id']        = Session::get('user_info.school_id');

            //插入数据库
            $user = f_student::create($data);

            if ($user == null) {
                $status  = 0;
                $message = '添加失败';
                return json(['status' => $status, 'message' => $message]);
            }
        } else {
            $status  = 0;
            $message = '添加失败';
            return json(['status' => $status, 'message' => $message]);
        }

        return json(['status' => $status, 'message' => $message, 'total' => 1]);
    }

    //显示添加信息表单
    public function show() {
        return view('../application/admin/view/dialog/AddStu.html');
    }

    /**
     * 获取课程数据
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function course() {
        $status  = 1;
        $message = '查询成功';
        $data    = array();

        //获取所有课程数据
        $courseInfo = f_course::all();

        if (!$courseInfo) {
            $status  = 0;
            $message = '没有数据';
            return json(['status' => $status, 'message' => $message]);
        }

        foreach ($courseInfo as $key => $value) {
            $data[] = $value->toArray();
        }
        return json(['status' => $status, 'message' => $message, 'data' => $data, 'total' => count($courseInfo)]);
    }

    /**
     * 在线咨询师数据
     * @return string|\think\response\Json
     * @throws \think\exception\DbException
     */
    public function onlineConsultant() {
        $status  = 1;
        $message = '查询成功';
        $data    = array();

        //获取角色ID为4的用户信息
        $onlineConsultantInfo = ref_user_role::all(['role_id' => 4]);

        if (!$onlineConsultantInfo) {
            $status  = 0;
            $message = '没有数据';
            return json(['status' => $status, 'message' => $message]);
        }

        foreach ($onlineConsultantInfo as $key => $value) {
            $userId[] = $value->toArray()['user_id'];
        }
        //获取用户信息
        $userInfo = f_user::all($userId);

        foreach ($userInfo as $key => $value) {
            $data[] = $value->toArray();
        }
        return json(['status' => $status, 'message' => $message, 'data' => $data, 'total' => count($userInfo)]);
    }

    /**
     * 课程顾问信息
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function courseConsultant() {
        $status  = 1;
        $message = '查询成功';
        $data    = array();
        //获取角色ID为5的用户信息
        $courseConsultant = ref_user_role::all(['role_id' => 5]);

        if (!$courseConsultant) {
            $status  = 0;
            $message = '没有数据';
            return json(['status' => $status, 'message' => $message]);
        }

        foreach ($courseConsultant as $key => $value) {
            $userId[] = $value->toArray()['user_id'];
        }

        //根据用户ID获取用户信息
        $userInfo = f_user::all($userId);

        if (!$userInfo) {
            $status  = 0;
            $message = '没有数据';
            return json(['status' => $status, 'message' => $message]);
        }
        foreach ($userInfo as $key => $value) {
            $data[] = $value->toArray();
        }
        return json(['status' => $status, 'message' => $message, 'data' => $data, 'total' => count($userInfo)]);
    }

    /**
     * 学员信息列表
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function stuList() {
        $status  = 1;
        $message = '查询成功';
        $stuList = array();

        //获取渠道ID
        $channel_id = f_channel::all(['channel_category' => '常规招生']);
        foreach ($channel_id as $key => $value) {
            $data[] = $value->toArray();
        }
        foreach ($data as $key => $value) {
            $channelId[] = $value['channel_id'];
        }

        //获取校区ID
        $school_id = Session::get('user_info.school_id');

        //查询条件
        $map['channel_id'] = array('in', $channelId);
        $map['school_id']  = array('eq', $school_id);

        //获取符合条件的所有数据
        $stu_list = f_student::all($map);
        if (empty($stu_list)) {
            $status  = 0;
            $message = '没有数据';
            return json(['status' => $status, 'message' => $message]);
        }

        foreach ($stu_list as $key => $value) {
            $stuList[] = $value->toArray();
        }

        foreach ($stuList as $key => $value) {
            $channel_list[]           = f_channel::get(['channel_id' => $value['channel_id']])->toArray();
            $online_consultant_list[] = f_user::get(['user_id' => $value['online_consultant_id']])->toArray();
            $course_consultant_list[] = f_user::get(['user_id' => $value['course_consultant_id']])->toArray();
            $school_list[]            = f_school::get(['school_id' => $value['school_id']])->toArray();
            $course_list[]            = f_course::get(['course_id' => $value['course_id']])->toArray();
            $create_list[]            = f_user::get(['user_id' => $value['create_id']])->toArray();
        }

        //查询所有数据返回的是三维数组
        $newStuList = array_map(null,$stuList,$channel_list,$online_consultant_list,$course_consultant_list,$school_list,$course_list,$create_list);
        var_dump($newStuList);die;
        return json(['status' => $status, 'message' => $message, 'data' => $newStuList, 'total' => count($stu_list)]);
    }

    /**
     * 学生信息获取
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function stuInfo(Request $request) {
        $status  = 1;
        $message = '查询成功';
        $stuInfo = array();

        //仅获取学生姓名
        $stuNameArr = $request->only(['student_name']);
        if (!$stuNameArr) {
            $status  = 1;
            $message = '查询失败，学生信息为空';
            return json(['status' => $status, 'message' => $message]);
        }

        $sudent_name = $stuNameArr['student_name'];

        //获取信息列表
        $stuListJson = $this->stuList();
        $stuList     = $stuListJson->getData();

        if (isset($stuList['data'])) {
            foreach ($stuList['data'] as $key => $value) {
                //判断姓名
                if ($sudent_name == $value[0]['student_name']) {
                    $stuInfo[] = $value;
                }
            }

            if (empty($stuInfo)) {
                $status  = 0;
                $message = '没有数据';
                return json(['status' => $status, 'message' => $message]);
            }
        } else {
            $status  = 0;
            $message = '没有数据';
            return json(['status' => $status, 'message' => $message]);
        }
        return json(['status' => $status, 'message' => $message, 'data' => $stuInfo, 'total' => count($stuInfo)]);
    }

    //展示回访记录
    public function callBack() {
        return view('../application/admin/view/dialog/AddCallback.html');
    }

    /**
     * @return \think\response\Json
     * @throws \think\exception\DbException
     * 获取回访人员信息（姓名）
     */
    public function revisit() {
        $status  = 1;
        $message = '查询成功';

        //从Session中获取校区
        $school_id = Session::get('user_info.school_id');

        //回访人信息
        $user_info = f_user::all(['school_id' => $school_id]);

        if (!$user_info) {
            $status  = 0;
            $message = '没有数据';
            return json(['status' => $status, 'message' => $message]);
        }

        //循环遍历获取姓名
        foreach ($user_info as $key => $value) {
            $data[] = $value->toArray();
        }
        foreach ($data as $key => $value) {
            $user_name[] = $value['user_name'];
        }
        return json(['status' => $status, 'message' => $message, 'data' => $user_name, 'total' => count($user_info)]);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * 添加回访记录
     */
    public function addCallBack(Request $request) {
        $status  = 1;
        $message = '添加成功';

        //获取回访表单数据
        $data = $request->param();
        if (!$data) {
            $status  = 0;
            $message = '获取数据失败';
            return json(['status' => $status, 'message' => $message]);
        }

        //从Session获取创建者
        $user_id = session::get('user_info.user_id');

        //将表单数据保存的data数组中
        $data['create_id']  = $user_id;
        $data['visit_time'] = date('Y-m-d H:i:s', strtotime($data['visit_time']));
        $visitWay           = array('电话', 'QQ', '微信', '面谈');
        $data['visit_way']  = $visitWay[$data['visit_way']];
        $willState          = array('非常有意向', '一般有意向', '意向不明', '无意向');
        $data['will_state'] = $willState[$data['will_state']];
        //TODO 临时处理
        $data['student_id'] = 1;

        //插入数据库
        $logVisit = log_visit::create($data);

        if ($logVisit == null) {
            $status  = 0;
            $message = '添加失败';
            return json(['status' => $status, 'message' => $message]);
        }
        return json(['status' => $status, 'message' => $message]);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * 渲染编辑模板
     */
    public function editStuShow(Request $request) {
        $status  = 1;
        $message = '数据查询成功';

        //接收编辑学生的ID
        $student_id = $request->only(['student_id']);

        //TODO 临时处理
        $student_id = 10;

        //根据学生id查询学生信息
        $stu_mes = f_student::get($student_id)->toArray();

        if (!$stu_mes) {
            $status  = 0;
            $message = '数据查询失败';
            $data    = array();
            return json(['status' => $status, 'message' => $message, 'data' => $data]);
        }

        //将上门时间和报名时间进行格式转换
        $stu_mes['first_visit_time'] = date('m/d/Y', strtotime($stu_mes['first_visit_time']));
        $stu_mes['register_time']    = date('m/d/Y', strtotime($stu_mes['register_time']));

        return json(['status' => $status, 'message' => $message, 'data' => $stu_mes]);

        //模板变量赋值
//        $this->assign('stu_mes',$stu_mes);
//        return view('../application/admin/view/dialog/EditStu.html');
//        return json(['status' => $status, 'message' => $message]);
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * 修改学生数据
     */
    public function updateStuAction(Request $request) {
        $status  = 1;
        $message = '修改成功';

        //获取表单提交数据
        $data = $request->param();

        //获取需要修改的学生ID
        $student_id = $request->only(['student_id']);

        //TODO 临时处理
        $student_id = 10;

        //通过学生ID获取学生信息
        if (!$stu_mes = f_student::get($student_id)->toArray()) {
            $status  = 0;
            $message = '没有该学生信息';
            return json(['status' => $status, 'message' => $message]);
        }

        //通过Session获取用户id
        $user_id = Session::get('user_info.user_id');

        //对表单数据进行处理
        $data['create_id']        = $stu_mes['create_id'];
        $data['last_update_id']   = $user_id;
        $data['first_visit_time'] = date('Y-m-d H:i:s', strtotime($data['first_visit_time']));
        $data['register_time']    = date('Y-m-d H:i:s', strtotime($data['register_time']));
        $gender                   = array('女', '男', '保密');
        $data['gender']           = $gender[$data['gender']];
        $education                = array('初中', '中专', '高中', '高职', '大专', '本科生', '研究生');
        $data['education']        = $education[$data['education']];
        $currentState             = array('在读学校', '在读离校', '待业', '在职', '自由职业');
        $data['current_state']    = $currentState[$data['current_state']];
        $visitState               = array('未上门', '已上门', '已报名');
        $data['visit_state']      = $visitState[$data['visit_state']];
        $data['school_id']        = Session::get('user_info.school_id');

        //修改学生信息
        $student = new f_student();
        $status  = $student->save($data, ['student_id' => $student_id]);
        if (!$status) {
            $status  = 0;
            $message = '修改失败';
            return json(['status' => $status, 'message' => $message]);
        }
        return json(['status' => $status, 'message' => $message]);
    }

}