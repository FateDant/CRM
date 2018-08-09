<?php
/**
 * 后台api接口
 */

namespace app\admin\controller;

use app\admin\model\f_channel;
use app\admin\model\f_course;
use app\admin\model\f_role;
use app\admin\model\f_school;
use app\admin\model\f_student;
use app\admin\model\f_user;
use app\admin\model\log_visit;
use app\admin\model\ref_user_role;
use think\Controller;
use think\Request;
use think\Session;

class CollegeGrid extends Controller {
    /**
     * 显示不同模块
     * @param Request $request
     * @return \think\response\Json|\think\response\View
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function showIndex(Request $request) {
        //从Session中获取学校id
        $school_id  = Session::get('user_info.school_id');
        $schoolInfo = f_school::get($school_id)->toArray();

        if (!$schoolInfo) {
            $status  = 0;
            $message = '查询失败';
            return json(['status' => $status, 'message' => $message]);
        }

        $school_name = $schoolInfo['school_name'];

        $request_id = $request->only('id');
        $model      = array('IndexCharts', 'DataGrid', 'RegularGrid', 'CollegeGrid', 'PraiseGrid', 'CampusGrid', 'UserGrid');
        $this->assign('school_name', $school_name);
        return view('../application/admin/view/grid/' . $model[$request_id['id']] . '.html');
    }

    /**
     * 校区信息下拉框
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function schoolList() {
        $status  = 1;
        $message = '查询成功';

        $school_list = f_school::all();
        foreach ($school_list as $key => $value) {
            $data[] = $value->toArray();
        }

        if (!$data) {
            $status  = 0;
            $message = '查询失败';
            return json(['status' => $status, 'message' => $message]);
        }

        return json(['status' => $status, 'message' => $message, 'data' => $data, 'total' => count($school_list)]);
    }

    /**
     * 获取模块
     * @param $id
     * @return mixed
     */
    private function moudelList($id) {
        $moudel_list = array('首页', '数据搜索', '常规招生', '院校招生', '口碑招生', '校区招生', '系统管理');
        $moudel      = $moudel_list[$id];
        return $moudel;
    }

    /**
     * 获取渠道信息
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function channelData(Request $request) {
        $status     = 1;
        $message    = '查询成功';
        $request_id = $request->only('id');
        $moudel     = $this->moudelList($request_id['id']);

        if ($moudel == '数据搜索') {
            $channel_list = f_channel::all();
            foreach ($channel_list as $key => $value) {
                $data[] = $value->toArray();
            }

            if (!$data) {
                $status  = 0;
                $message = '没有数据';
                return json(['status' => $status, 'message' => $message]);
            }
            return json(['status' => $status, 'message' => $message, 'data' => $data, 'total' => count($channel_list)]);
        } else {
            $channel_list = f_channel::all(['channel_category' => $moudel]);
            if (empty($channel_list)) {
                $status  = 0;
                $message = '查询失败';
                return json(['status' => $status, 'message' => $message]);
            } else {
                foreach ($channel_list as $key => $value) {
                    $data[] = $value->toArray();
                }

                if (!$data) {
                    $status  = 0;
                    $message = '查询失败';
                    return json(['status' => $status, 'message' => $message]);
                }
                return json(['status' => $status, 'message' => $message, 'data' => $data, 'total' => count($channel_list)]);
            }
        }
    }

    /**
     * 获取课程数据
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function courseData() {
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
     * 获取在线咨询师信息
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function onlineConsultantData(Request $request) {
        $status     = 1;
        $message    = '查询成功';
        $request_id = $request->only('id');
        $moudel     = $this->moudelList($request_id['id']);

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

        $userInfo = f_user::all($userId);
        foreach ($userInfo as $key => $value) {
            $data[] = $value->toArray();
        }

        if ($moudel == '数据搜索') {
            if (!$data) {
                $status  = 0;
                $message = '没有数据';
                return json(['status' => $status, 'message' => $message]);
            }
            return json(['status' => $status, 'message' => $message, 'data' => $data, 'total' => count($userInfo)]);
        } else {
            $newdata   = array();
            $school_id = Session::get('user_info.school_id');
            foreach ($userInfo as $key => $value) {
                $value->toArray()['school_id'] == $school_id ? ($newdata[] = $data[$key]) : '';
            }
            if (empty($newdata)) {
                $status  = 0;
                $message = '没有数据';
                return json(['status' => $status, 'message' => $message]);
            }
            return json(['status' => $status, 'message' => $message, 'data' => $newdata, 'total' => count($newdata)]);
        }
    }

    /**
     * 获取课程顾问信息
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function courseConsultantData(Request $request) {
        $status     = 1;
        $message    = '查询成功';
        $request_id = $request->only('id');
        $moudel     = $this->moudelList($request_id['id']);

        //获取角色ID为5的用户信息
        $onlineConsultantInfo = ref_user_role::all(['role_id' => 5]);
        if (!$onlineConsultantInfo) {
            $status  = 0;
            $message = '没有数据';
            return json(['status' => $status, 'message' => $message]);
        }

        foreach ($onlineConsultantInfo as $key => $value) {
            $userId[] = $value->toArray()['user_id'];
        }

        $userInfo = f_user::all($userId);
        foreach ($userInfo as $key => $value) {
            $data[] = $value->toArray();
        }

        if ($moudel == '数据搜索') {
            if (!$data) {
                $status  = 0;
                $message = '没有数据';
                return json(['status' => $status, 'message' => $message]);
            }
            return json(['status' => $status, 'message' => $message, 'data' => $data, 'total' => count($userInfo)]);
        } else {
            $newdata   = array();
            $school_id = Session::get('user_info.school_id');
            foreach ($userInfo as $key => $value) {
                $value->toArray()['school_id'] == $school_id ? ($newdata[] = $data[$key]) : '';
            }
            if (empty($newdata)) {
                $status  = 0;
                $message = '没有数据';
                return json(['status' => $status, 'message' => $message]);
            }
            return json(['status' => $status, 'message' => $message, 'data' => $newdata, 'total' => count($newdata)]);
        }
    }

    /**
     * 获取回访人员姓名
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function revisitName() {
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

        return json(['status' => $status, 'message' => $message, 'data' => $data, 'total' => count($user_info)]);
    }

    /**
     * 添加回访记录
     * @param Request $request
     * @return \think\response\Json
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

        $visit_way          = array('电话' => 1, '微信' => 2, 'QQ' => 3, '面谈' => 4);
        $data['visit_way']  = $visit_way[$data['visit_way']];
        $sill_state         = array('非常有意向' => 1, '一般有意向' => 2, '意向不明' => 3, '无意向' => 4);
        $data['will_state'] = $sill_state[$data['will_state']];
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
     * 查询回访记录
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function selectRevisitData(Request $request) {
        $status  = 1;
        $message = '查询成功';

        $student_id = $request->only('student_id');

        if ($request->get('page_size')) {
            $page_size = $request->get('page_size');
        } else {
            $page_size = 5;
        }

        if ($request->get('now_page')) {
            $now_page = $request->get('now_page');
        } else {
            $now_page = 1;
        }

        $visit_info = log_visit::all(function ($query) use ($student_id, $page_size, $now_page) {
            $query->where('student_id', $student_id['student_id'])->page($now_page, $page_size)->order('visit_id', 'desc');
        });

        if (!$visit_info) {
            $status  = 0;
            $message = '没有数据';
            $data    = ['visit_time' => '', 'visit_way' => '', 'will_state' => '', 'call_username' => '', 'log_detail' => ''];
            return json(['status' => $status, 'message' => $message, 'data' => $data, 'total' => 0]);
        }

        foreach ($visit_info as $key => $value) {
            $call_name_list              = f_user::get(['user_id' => $value['call_userid']])->toArray();
            $visit_list                  = $value->toArray();
            $visit_list['call_username'] = $call_name_list['user_name'];
            $new_visit_list[]            = $visit_list;
        }
        return json(['status' => $status, 'message' => $message, 'data' => $new_visit_list, 'total' => count($new_visit_list)]);
    }

    /**
     * 获取学生信息列表
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function stuListData(Request $request) {
        $status     = 1;
        $message    = '查询成功';
        $stuList    = array();
        $request_id = $request->only('id');
        $moudel     = $this->moudelList($request_id['id']);
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
            //说明没有传入条件
            if ($moudel == '数据搜索') {
                $stu_info = f_student::all(function ($query) use ($page_size, $now_page) {
                    $query->page($now_page, $page_size)->order('school_id', 'desc');
                });

                foreach ($stu_info as $key => $value) {
                    $stu_list[] = $value->toArray();
                }
                if (!$stu_list) {
                    $status  = 0;
                    $message = '没有数据';
                    return json(['status' => $status, 'message' => $message]);
                }

                foreach ($stu_list as $key => $value) {
                    $channel_list           = f_channel::get(['channel_id' => $value['channel_id']])->toArray();
                    $online_consultant_list = f_user::get(['user_id' => $value['online_consultant_id']])->toArray();
                    $course_consultant_list = f_user::get(['user_id' => $value['course_consultant_id']])->toArray();
                    $school_list            = f_school::get(['school_id' => $value['school_id']])->toArray();
                    $create_list            = f_user::get(['user_id' => $value['create_id']])->toArray();
                    $course_list            = f_course::get(['course_id' => $value['course_id']])->toArray();

                    $value['channel_name']               = $channel_list['channel_name'];
                    $value['channel_category']           = $channel_list['channel_category'];
                    $value['channel_desc']               = $channel_list['channel_desc'];
                    $value['online_consultant_name']     = $online_consultant_list['user_name'];
                    $value['online_consultant_emp_name'] = $online_consultant_list['emp_name'];
                    $value['online_consultant_email']    = $online_consultant_list['email'];
                    $value['online_consultant_mobile']   = $online_consultant_list['mobile'];
                    $value['online_consultant_desc']     = $online_consultant_list['desc'];
                    $value['course_consultant_name']     = $course_consultant_list['user_name'];
                    $value['course_consultant_emp_name'] = $course_consultant_list['emp_name'];
                    $value['course_consultant_email']    = $course_consultant_list['email'];
                    $value['course_consultant_mobile']   = $course_consultant_list['mobile'];
                    $value['course_consultant_desc']     = $course_consultant_list['desc'];
                    $value['school_name']                = $school_list['school_name'];
                    $value['school_desc']                = $school_list['school_desc'];
                    $value['create_name']                = $create_list['user_name'];
                    $value['create_emp_name']            = $create_list['emp_name'];
                    $value['create_email']               = $create_list['email'];
                    $value['create_mobile']              = $create_list['mobile'];
                    $value['create_desc']                = $create_list['desc'];
                    $value['course_name']                = $course_list['course_name'];

                    $newStuList[] = $value;
                }
                return json(['status' => $status, 'message' => $message, 'data' => $newStuList, 'total' => count($stu_list)]);
            } else {
                //获取渠道ID
                $channel_id = f_channel::all(['channel_category' => $moudel]);

                if (!$channel_id) {
                    $status  = 0;
                    $message = '没有数据';
                    return json(['status' => $status, 'message' => $message]);
                }
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
                $stu_list = f_student::all(function ($query) use ($map, $page_size, $now_page) {
                    $query->where($map)->page($now_page, $page_size)->order('school_id', 'desc');
                });

                if (empty($stu_list)) {
                    $status  = 0;
                    $message = '没有数据';
                    return json(['status' => $status, 'message' => $message]);
                }

                foreach ($stu_list as $key => $value) {
                    $stuList[] = $value->toArray();
                }

                foreach ($stuList as $key => $value) {
                    $channel_list           = f_channel::get(['channel_id' => $value['channel_id']])->toArray();
                    $online_consultant_list = f_user::get(['user_id' => $value['online_consultant_id']])->toArray();
                    $course_consultant_list = f_user::get(['user_id' => $value['course_consultant_id']])->toArray();
                    $school_list            = f_school::get(['school_id' => $value['school_id']])->toArray();
                    $create_list            = f_user::get(['user_id' => $value['create_id']])->toArray();
                    $course_list            = f_course::get(['course_id' => $value['course_id']])->toArray();

                    $value['channel_name']               = $channel_list['channel_name'];
                    $value['channel_category']           = $channel_list['channel_category'];
                    $value['channel_desc']               = $channel_list['channel_desc'];
                    $value['online_consultant_name']     = $online_consultant_list['user_name'];
                    $value['online_consultant_emp_name'] = $online_consultant_list['emp_name'];
                    $value['online_consultant_email']    = $online_consultant_list['email'];
                    $value['online_consultant_mobile']   = $online_consultant_list['mobile'];
                    $value['online_consultant_desc']     = $online_consultant_list['desc'];
                    $value['course_consultant_name']     = $course_consultant_list['user_name'];
                    $value['course_consultant_emp_name'] = $course_consultant_list['emp_name'];
                    $value['course_consultant_email']    = $course_consultant_list['email'];
                    $value['course_consultant_mobile']   = $course_consultant_list['mobile'];
                    $value['course_consultant_desc']     = $course_consultant_list['desc'];
                    $value['school_name']                = $school_list['school_name'];
                    $value['school_desc']                = $school_list['school_desc'];
                    $value['create_name']                = $create_list['user_name'];
                    $value['create_emp_name']            = $create_list['emp_name'];
                    $value['create_email']               = $create_list['email'];
                    $value['create_mobile']              = $create_list['mobile'];
                    $value['create_desc']                = $create_list['desc'];
                    $value['course_name']                = $course_list['course_name'];

                    $newStuList[] = $value;
                }
                return json(['status' => $status, 'message' => $message, 'data' => $newStuList, 'total' => count($stu_list)]);
            }
        } else {
            $data_list = $request->param();
            $school_id = Session::get('user_info.user_id');

            $channel = $this->channelData($request)->getData()['data'];
            foreach ($channel as $value) {
                $default_channel[] = $value['channel_name'];
            }

            isset($data_list['school_id']) ? $map['school_id'] = $data_list['school_id'] : $map['school_id'] = $school_id;
            isset($data_list['student_name']) ? $map['student_name'] = $data_list['student_name'] : '';
            isset($data_list['channel_id']) ? $map['channel_id'] = $data_list['channel_id'] : '';
            isset($data_list['mobile']) ? $map['mobile'] = $data_list['mobile'] : '';
            isset($data_list['online_consultant_id']) ? $map['online_consultant_id'] = $data_list['online_consultant_id'] : '';
            isset($data_list['education']) ? $map['education'] = $data_list['education'] : '';
            isset($data_list['current_state']) ? $map['current_state'] = $data_list['current_state'] : '';
            isset($data_list['course_consultant_id']) ? $map['course_consultant_id'] = $data_list['course_consultant_id'] : '';

            $stu_info = f_student::all(function ($query) use ($map, $page_size, $now_page) {
                $query->where($map)->page($now_page, $page_size)->order('school_id', 'desc');
            });

            if (empty($stu_info)) {
                $status  = 0;
                $message = '没有数据';
                return json(['status' => $status, 'message' => $message]);
            }

            foreach ($stu_info as $key => $value) {
                $stu_list[] = $value->toArray();
            }

            foreach ($stu_list as $key => $value) {
                $channel_list           = f_channel::get(['channel_id' => $value['channel_id']])->toArray();
                $online_consultant_list = f_user::get(['user_id' => $value['online_consultant_id']])->toArray();
                $course_consultant_list = f_user::get(['user_id' => $value['course_consultant_id']])->toArray();
                $school_list            = f_school::get(['school_id' => $value['school_id']])->toArray();
                $create_list            = f_user::get(['user_id' => $value['create_id']])->toArray();
                $course_list            = f_course::get(['course_id' => $value['course_id']])->toArray();

                $value['channel_name']               = $channel_list['channel_name'];
                $value['channel_category']           = $channel_list['channel_category'];
                $value['channel_desc']               = $channel_list['channel_desc'];
                $value['online_consultant_name']     = $online_consultant_list['user_name'];
                $value['online_consultant_emp_name'] = $online_consultant_list['emp_name'];
                $value['online_consultant_email']    = $online_consultant_list['email'];
                $value['online_consultant_mobile']   = $online_consultant_list['mobile'];
                $value['online_consultant_desc']     = $online_consultant_list['desc'];
                $value['course_consultant_name']     = $course_consultant_list['user_name'];
                $value['course_consultant_emp_name'] = $course_consultant_list['emp_name'];
                $value['course_consultant_email']    = $course_consultant_list['email'];
                $value['course_consultant_mobile']   = $course_consultant_list['mobile'];
                $value['course_consultant_desc']     = $course_consultant_list['desc'];
                $value['school_name']                = $school_list['school_name'];
                $value['school_desc']                = $school_list['school_desc'];
                $value['create_name']                = $create_list['user_name'];
                $value['create_emp_name']            = $create_list['emp_name'];
                $value['create_email']               = $create_list['email'];
                $value['create_mobile']              = $create_list['mobile'];
                $value['create_desc']                = $create_list['desc'];
                $value['course_name']                = $course_list['course_name'];

                $newStuList[] = $value;
            }
            return json(['status' => $status, 'message' => $message, 'data' => $newStuList, 'total' => count($stu_list)]);
        }
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
            $data['consult_time']     = date('Y-m-d H:i:s', strtotime($data['consult_time']));
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

    /**
     * 更新学生信息
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function updateStuAction(Request $request) {
        $status  = 1;
        $message = '修改成功';

        //获取表单提交数据
        $data = $request->param();

        //获取需要修改的学生ID
        $student_id = $request->only(['student_id']);

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
        $data['consult_time']     = date('Y-m-d H:i:s', strtotime($data['consult_time']));
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

    /**
     * 添加、编辑学生表单
     * @return \think\response\View
     */
    public function addStu() {
        return view('../application/admin/view/dialog/AddStu.html');
    }

    /**
     * 显示回访表单
     * @return \think\response\View
     */
    public function callBack() {
        return view('../application/admin/view/dialog/AddCallback.html');
    }
}