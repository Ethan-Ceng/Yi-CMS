<?php

// This file is auto-generated, don't edit it. Thanks.
namespace app\common\lib\sms;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;

class AliSMS {

    /**
     * 使用AK&SK初始化账号Client
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @return Dysmsapi Client
     */
    public static function createClient($accessKeyId, $accessKeySecret){
        $config = new Config([
            // 您的AccessKey ID
            "accessKeyId" => $accessKeyId,
            // 您的AccessKey Secret
            "accessKeySecret" => $accessKeySecret
        ]);
        // 访问的域名
        $config->endpoint = "dysmsapi.aliyuncs.com";
        return new Dysmsapi($config);
    }

    /**
     * @param string[] $args
     * @return void
     */
    public static function main($args){
        $client = self::createClient(config("aliyun.access_key"), config("aliyun.access_key_secret"));

        $sendSmsRequest = new SendSmsRequest([
            "phoneNumbers" => "",
            "signName" => config("aliyun.sing_name"),
            "templateCode" => config("aliyun.template_code")
        ]);
        
        // 复制代码运行请自行打印 API 的返回值
        $client->sendSms($sendSmsRequest);
    }
}
