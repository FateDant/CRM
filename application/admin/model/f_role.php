<?php

namespace app\admin\model;

use think\Model;

class f_role extends Model {
    public function getUser(){
        return $this->belongsToMany('f_user','ref_user_role','user_id','role_id');
    }

    public function getPriv(){
        return $this->belongsToMany('f_privilege','ref_role_priv','priv_id','role_id');
    }
}