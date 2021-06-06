<?php

namespace app\common\lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MailService
{
    /**
     * @param $to
     * @param string $subject
     * @param string $content
     * @param string $addAttachment 附件
     * @return array
     * @throws Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:发送邮件
     */
    public static function sendEmail($to, $subject = '', $content = '', $addAttachment = '')
    {
        // 判断openssl是否开启
        $openssl_funcs = get_extension_funcs('openssl');
        if (!$openssl_funcs) {
            return json([
                'data' => '',
                'resultCode' => 0,
                'resultMsg' => '请先开启openssl扩展'
            ]);
        }

        $config = config("system");
        dump($config);
        $mail = new PHPMailer();

        // 设置发送的邮件的编码
        $mail->CharSet  = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->isSMTP();
        // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug = 0;
        // smtp需要鉴权 这个必须是true
        $mail->SMTPAuth = true;
        //调试输出格式
        $mail->Debugoutput = 'html';


        // 链接qq域名邮箱的服务器地址
        $mail->Host = $config['mail_smtp_host'];
        //端口 - likely to be 25, 465 or 587
        $mail->Port = $config['mail_smtp_port'];
        $mail->SMTPSecure = $config['mail_secure']; // 使用安全协议 tls,ssl
        // smtp登录的账号 QQ邮箱即可
        $mail->Username = $config['mail_smtp_user'];
        // smtp登录的密码 使用生成的授权码
        $mail->Password = $config['mail_smtp_pass'];

        //Set who the message is to be sent from
        $mail->setFrom($config['mail_smtp_user'], $config['mail_smtp_name']);
        //回复地址
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //接收邮件方
        if (is_array($to)) {
            foreach ($to as $v) {
                $mail->addAddress($v);
            }
        } else {
            $mail->addAddress($to);
        }

        // 邮件正文是否为html编码 注意此处是一个方法
        $mail->isHTML(true);

        // 添加该邮件的主题
        $mail->Subject = $subject;
        // 添加邮件正文
        $mail->Body = $content;
        // 为该邮件添加附件
        if (!empty($addAttachment)) {
            $mail->addAttachment($addAttachment);
        }
        
        try {
            // 发送邮件 返回状态
            $result = $mail->send();
            return json([
                'data' => $result,
                'resultCode' => 0,
                'resultMsg' => '发送成功'
            ]);

        } catch (\Exception $e) {

            return json([
                'data' => '',
                'resultCode' => 1,
                'resultMsg' => $e->getMessage()
            ]);
        }
    }
}
