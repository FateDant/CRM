<?php
/**
 * 口碑招生
 */

namespace app\admin\controller;

use app\admin\model\SchName;
use think\Controller;
use app\admin\model\PraiseGrid as PraiseGridModel;
use think\Session;

class PraiseGrid extends Controller {
    public function index() {
        $school_id                  = Session::get('user_info.school_id');
        $schoolInfo = SchName::get($school_id)->toArray();
        $school_name = $schoolInfo['school_name'];
        $this -> assign('school_name',$school_name);
        return view('../application/admin/view/grid/PraiseGrid.html');
    }

    //获取渠道数据
    public function channel() {
        $channelInfo = PraiseGridModel::all(['channel_category' => '口碑招生']);
        if (!$channelInfo) {
            $message = '没有数据';
            return $message;
        }
        foreach ($channelInfo as $key => $value) {
            $data[] = $value->toArray();
        }
        //返回口碑招生的数组
        return json($data);

    }
}