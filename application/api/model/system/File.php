<?php
/**
 * Created by PhpStorm.
 * User: 沁塵
 * Date: 2019/6/4
 * Time: 15:10
 */

namespace app\api\model\system;


use think\Model;
use think\model\concern\SoftDelete;

class File extends Model
{
    protected $table = 'system_file';

    use SoftDelete;
    protected $autoWriteTimestamp = 'datetime';
    protected $hidden = ['delete_time', 'update_time'];
}