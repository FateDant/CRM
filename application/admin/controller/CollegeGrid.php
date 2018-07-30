<?php
/**
 * 院校招生
 */

namespace app\admin\controller;

use app\admin\model\f_school;
use app\admin\model\SchName;
use think\Controller;
use app\admin\model\CollegeGrid as CollegeGridModel;
use think\Session;

class CollegeGrid extends Controller {
    public function index() {
        $school_id = Session::get('user_info.school_id');
        $schoolInfo = f_school::get($school_id)->toArray();
        $school_name = $schoolInfo['school_name'];
//        $this->assign('school_name', $school_name);
//        return view('../application/admin/view/grid/CollegeGrid.html');
    }

    //获取渠道数据
    public function channel() {
        $channelInfo = CollegeGridModel::all(['channel_category' => '院校招生']);
        if (!$channelInfo) {
            $message = '没有数据';
            return $message;
        }
        foreach ($channelInfo as $key => $value) {
            $data[] = $value->toArray();
        }
        //返回院校招生的数组
        return json($data);
    }
}