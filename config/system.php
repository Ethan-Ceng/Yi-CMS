
<?php
// +----------------------------------------------------------------------
// | 系统设置
// +----------------------------------------------------------------------

return [
    // 应用 Session 域
    'session_scope'         => 'think_mall',
    // 密码加密
    'pwd_salt' => 'mall',
    'token_salt' => '520025',
    'token_expire' => 72000,
    // image
    'image_prefix' => 'http://tinker.localhost.com/storage/images',

    // 邮件配置
    //smtp 服务器地址
    "mail_smtp_host" => "smtp.qq.com",
    //smtp 端口
    "mail_smtp_port" => "465",
    // 设置使用ssl加密方式登录鉴权
    "mail_secure" => "ssl",
    // smtp登录的账号 QQ邮箱即可
    "mail_smtp_user" => env('system.mail_smtp_user', ''),
    // smtp登录的密码 使用生成的授权码
    "mail_smtp_pass" => env('system.mail_smtp_pass', ''),
    // 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
    "mail_smtp_name" => "Yi - CMS",
];