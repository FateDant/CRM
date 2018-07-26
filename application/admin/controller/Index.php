<?php
/**
 * 首页总览
 */
namespace app\admin\controller;


use app\index\controller\Base;


class Index extends Base {
    public function index() {
        $this->isLogin(); //判断用户是否登录
        return $this->view->fetch();
    }
}
