<?php
namespace app\admin\controller;



use app\BaseController;

class Upload extends BaseController
{
    /**
     * 上传用户头像
     */
    public function uploadAvatar()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // TODO: 1、上传文件类型判断限制；2、文件大小限制
        // 上传到本地服务器
        $saveName = \think\facade\Filesystem::disk('public')->putFile( 'avatar', $file);
        $filePath = str_replace("\\",'/', '/upload/' . $saveName);
        return json([
            'data' => $filePath,
            'resultMsg' => '上传成功',
            'resultCode' => 0
        ]);
    }

    /**
     * 多文件上传
     * multiple Upload
     */
    public function multipleUpload()
    {
    }
}
