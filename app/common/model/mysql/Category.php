<?php


namespace app\common\model\mysql;


use app\common\exception\MessageException;

class Category extends BaseModel
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'category';

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
            throw new MessageException(['resultMsg' => '分类名不合法']);
        }

        $data = ['name' => $name];
        return $this->where($data)->find();
    }

    public function getCategoryTree(){
        $data = $this->where('status', '1')->select()->toArray();
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

    public function getTree($array, $pid = 0, $level = 0)
    {
        //声明静态数组,避免递归调用时,多次声明导致数组覆盖 TODO: 循环遍历次数过多，unset 好像并没有缩小数组长度，每次便利任然是全量遍历
        $list = [];
        foreach ($array as $key => $value) {
            //第一次遍历,找到父节点为根节点的节点 也就是pid=0的节点
            if ($value['pid'] == $pid) {
                // 把这个节点从数组中移除,减少后续递归消耗
                unset($array[$key]);

                //父节点为根节点的节点,级别为0，也就是第一级
                $value['level'] = $level;
                $value['label'] = $value['name'];

                //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
                $value['children'] = $this->getTree($array, $value['id'], $level + 1);

                //把数组放到list中
                $list[] = $value;
            }
        }
        return $list;
    }
}