<?php

namespace app\admin\model;

use think\Model;

class User extends Model {
    protected $table = 'f_user';
    protected $data;

    public function showDate() {
        return $this->data;
    }
}