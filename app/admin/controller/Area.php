<?php


namespace app\admin\controller;

use app\BaseController;
use app\common\model\mysql\Area as AreaModel;

class Area extends BaseController
{
    // 列表所有
    public function list()
    {
        $AreaModel = new AreaModel();
        $result = $AreaModel->getArea();
         halt($result);
        return json([
            'data' => $result,
            'resultCode' => 0,
            'resultMsg' => '查询成功'
        ]);
    }
}