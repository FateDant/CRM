<?php
/**
 * 常规招生
 */

namespace app\admin\controller;

use app\admin\model\SchName;
use think\Controller;
use app\admin\model\RegularGrid as RegularGridModel;
use think\Session;

class RegularGrid extends Controller {
    public function index() {
        $school_id                  = Session::get('user_info.school_id');
        $schoolInfo = SchName::get($school_id)->toArray();
        $school_name = $schoolInfo['school_name'];
        $this -> assign('school_name',$school_name);
        return view('../application/admin/view/grid/RegularGrid.html');
    }

    //获取渠道数据
    public function channel() {
        $channelInfo = RegularGridModel::all(['channel_category' => '常规招生']);
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
}