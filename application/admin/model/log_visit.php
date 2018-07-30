<?php

namespace app\admin\model;

use think\Model;

class log_visit extends Model {
    protected $table = 'log_visit';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'create_time';
    protected $updateTime = false;
}