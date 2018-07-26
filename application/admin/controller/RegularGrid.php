<?php
/**
 * 常规招生
 */

namespace app\admin\controller;

use think\Controller;
use app\admin\model\RegularGrid as RegularGridModel;

class RegularGrid extends Controller {
    public function index() {
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