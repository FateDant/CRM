<?php
/**
 * 首页总览
 */
namespace app\admin\controller;

use think\Controller;

class IndexCharts extends Controller
{
    public function index(){
        return view('../application/admin/view/grid/IndexCharts.html');
    }
}
