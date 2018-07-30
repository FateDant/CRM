<?php

namespace app\admin\model;

use think\Model;

class f_student extends Model {
    protected $table = 'f_student';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'create_time';
    protected $updateTime = 'last_update_time';

}