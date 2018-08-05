<?php
/**
 * 数据统计
 */

namespace app\admin\controller;

use app\admin\model\f_channel;
use app\admin\model\f_course;
use app\admin\model\f_school;
use app\admin\model\f_student;
use app\admin\model\f_user;
use think\Controller;
use think\Request;
use think\Session;

class DataGrid extends Controller {
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
        return view('../application/admin/view/grid/DataGrid.html');
    }

    /**
     * 校区信息
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
     * 渠道信息
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function channelList() {
        $status  = 1;
        $message = '查询成功';

        $channel_list = f_channel::all();
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

    /**
     * 学生信息查询和列表
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function searchData(Request $request) {
        $status    = 1;
        $message   = '查询成功';
        $stu_list  = array();
        $list_data = $request->param();
        $map       = array();

        if (!$list_data) {
            //如果没有接受到条件默认查询所有数据
            $stu_info = f_student::all();
            foreach ($stu_info as $key => $value) {
                $stu_list[] = $value->toArray();
            }
            if (!$stu_list) {
                $status  = 0;
                $message = '查询失败';
                return json(['status' => $status, 'message' => $message]);
            }

            foreach ($stu_list as $key => $value) {
                $channel_list[]           = f_channel::get(['channel_id' => $value['channel_id']])->toArray();
                $online_consultant_list[] = f_user::get(['user_id' => $value['online_consultant_id']])->toArray();
                $course_consultant_list[] = f_user::get(['user_id' => $value['course_consultant_id']])->toArray();
                $school_list[]            = f_school::get(['school_id' => $value['school_id']])->toArray();
                $course_list[]            = f_course::get(['course_id' => $value['course_id']])->toArray();
                $create_list[]            = f_user::get(['user_id' => $value['create_id']])->toArray();
            }
            $newStuList = array_map(null, $stu_list, $channel_list, $online_consultant_list, $course_consultant_list, $school_list, $course_list, $create_list);
            return json(['status' => $status, 'message' => $message, 'data' => $newStuList, 'total' => count($stu_list)]);
        } else {
            $education     = array('初中', '中专', '高中', '高职', '大专', '本科', '研究生');
            $current_state = array('在读学校', '在读离校', '待业', '在职', '自由职业');
            $will_state    = array('非常有意向', '一般有意向', '意向不明', '无意向');
            $list_data['school_id'] == -1 ? '' : $map['school_id'] = $list_data['school_id'];
            $list_data['channel_id'] == -1 ? '' : $map['channel_id'] = $list_data['channel_id'];
            empty($list_data['mobile']) ? '' : $map['mobile'] = $list_data['mobile'];
            $list_data['online_consultant_id'] == -1 ? '' : $map['online_consultant_id'] = $list_data['online_consultant_id'];
            $list_data['education'] == -1 ? '' : $map['education'] = $education[$list_data['education']];
            $list_data['current_state'] == -1 ? '' : $map['current_state'] = $current_state[$list_data['current_state']];
            $list_data['will_state'] == -1 ? '' : $map['will_state'] = $will_state[$list_data['will_state']];
            $list_data['course_consultant_id'] == -1 ? '' : $map['course_consultant_id'] = $list_data['course_consultant_id'];

            $stu_info = f_student::all($map);
            foreach ($stu_info as $key => $value) {
                $stu_list[] = $value->toArray();
            }

            if (!$stu_list) {
                $status  = 0;
                $message = '查询失败';
                return json(['status' => $status, 'message' => $message]);
            }

            foreach ($stu_list as $key => $value) {
                $channel_list[]           = f_channel::get(['channel_id' => $value['channel_id']])->toArray();
                $online_consultant_list[] = f_user::get(['user_id' => $value['online_consultant_id']])->toArray();
                $course_consultant_list[] = f_user::get(['user_id' => $value['course_consultant_id']])->toArray();
                $school_list[]            = f_school::get(['school_id' => $value['school_id']])->toArray();
                $course_list[]            = f_course::get(['course_id' => $value['course_id']])->toArray();
                $create_list[]            = f_user::get(['user_id' => $value['create_id']])->toArray();
            }
            $newStuList = array_map(null, $stu_list, $channel_list, $online_consultant_list, $course_consultant_list, $school_list, $course_list, $create_list);
            return json(['status' => $status, 'message' => $message, 'data' => $newStuList, 'total' => count($stu_list)]);
        }
    }
}