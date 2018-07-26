<?php
/**
 * 口碑招生
 */

namespace app\admin\controller;

use think\Controller;
use app\admin\model\PraiseGrid as PraiseGridModel;

class PraiseGrid extends Controller {
    public function index() {
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