<?php

namespace app\index\model;

use think\Model;

class User extends Model {
    protected $table = 'f_user';
    protected $data;
    public function showDate(){
        return $this ->data;
    }
}