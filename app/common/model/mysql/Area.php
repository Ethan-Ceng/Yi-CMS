<?php


namespace app\common\model\mysql;


class Area extends BaseModel
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'area';

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 模型初始化
    protected static function init()
    {
        // TODO:初始化内容
    }

    // 检查分类名是否存在
    public function checkName($name)
    {
        if (!$name) {
            exception('分类名不合法');
        }

        $data = ['name' => $name];
        return $this->where($data)->find();
    }

    public function getArea(){
        $data = $this->select()->toArray();
        $list = $this->getTree($data);
        return $list;
    }

    /**
     * 递归实现无限极分类
     * @param $array 分类数据
     * @param $pid 父ID
     * @param $level 分类级别
     * @return $list 分好类的数组 直接遍历即可 $level可以用来遍历缩进
     */
    public function getTree($data,$pid = 0,$level = 0)
    {
        $trees = [];
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                unset($data[$k]);
                $v['level']=$level;
                $v['childrenItem'] = $this->getTree($data,$v['id'],$level+1 );
                $trees[] = $v;
            }
        }
        return $trees;
    }
}