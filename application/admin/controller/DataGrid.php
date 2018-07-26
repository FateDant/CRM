<?php
/**
 * 数据统计
 */

namespace app\admin\controller;

use think\Controller;

class DataGrid extends Controller {
    public function index() {
        return view('../application/admin/view/grid/DataGrid.html');
    }
}