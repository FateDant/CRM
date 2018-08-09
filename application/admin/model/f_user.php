<?php

namespace app\admin\model;

use think\Model;

class f_user extends Model {
    protected $table = 'f_user';
    protected $data;

//    public function showDate() {
//        return $this->data;
//    }
    public function getRole(){
        return $this->belongsToMany('f_role','ref_user_role','role_id','user_id');
    }
}