<?php
/**
 * 数据统计
 */

namespace app\admin\controller;

use app\admin\model\f_school;
use think\Controller;
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

    public function schoolList() {
        $status = 1;
        $message = '查询成功';

        $school_list = f_school::all();
        foreach ($school_list as $key => $value){
            $data[] = $value->toArray();
        }

        if (!$data)

        return json(['status' => $status, 'message' => $message,'data' => $data]);
    }
}