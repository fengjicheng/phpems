<?php
/**
 * Created by PhpStorm.
 * User: xuefeng
 * Date: 2018/3/14
 * Time: 23:42
 */

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Dept extends Model
{
    protected $table = 'dept';
    protected $primaryKey = 'deptid';
    public $timestamps = false;
    // 获取考试记录
    public function users()
    {
        return $this->hasMany(ExamHistory::class, 'deptid');
    }
}
