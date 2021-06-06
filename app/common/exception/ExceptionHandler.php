<?php
/**
 * 自定义错误处理类，统一错误返回结果
 */

namespace app\common\exception;


use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\exception\Handle;
use think\Response;
use Throwable;
use think\facade\Env;
// use think\facade\Log;

class ExceptionHandler extends Handle
{
    /**
     * http status 400,200
     * 2** 请求成功
     *
     * 4** 请求错误，妨碍服务器处理
     * 400 错误请求
     * 401 未授权，请求要求身份验证
     * 403 禁止，服务器拒绝请求
     * 404 未找到，服务器找不到请求资源
     *
     * 500 （服务器内部错误） 服务器遇到错误，无法完成请求。
     */
    private $httpStatus;
    // 自定义错误码 正常 0，异常 1
    private $resultCode;
    // 错误具体信息
    private $resultMsg;

    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     * 添加自定义异常处理机制
     * @access public
     * @param \think\Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 请求异常
        if ($e instanceof HttpException) {
            $this->report($e);
            return json([
                'resultCode' => $e->getStatusCode(),
                'resultMsg' => $e->getMessage(),
                'requestUrl' => $request->url()
            ]);
        }

        // 自定义错误类错误
        if ($e instanceof BaseException) {
            $this->httpStatus = $e->httpStatus;
            $this->resultMsg = $e->resultMsg;
            $this->resultCode = $e->resultCode;

            $result = [
                'resultCode' => $this->resultCode,
                'resultMsg' => $this->resultMsg,
                'requestUrl' => $request->url()
            ];

            return json($result, $this->httpStatus);
        }


        // 判断 APP_DEBUG 开发环境不展示系统错误
        if (Env::get('APP_DEBUG')) {
            // 其他错误交给系统处理
            return parent::render($request, $e);
        } else {
            $this->httpStatus = 500;
            $this->resultMsg = '服务器内部错误！';
            $this->resultCode = 999;
            $this->report($e);
            // $message = '请求地址：'. $request->url() . ' 错误信息：' . $e->getMessage();
            // Log::error($message);
        }
        $result = [
            'resultCode' => $this->resultCode,
            'resultMsg' => $this->resultMsg,
            'requestUrl' => $request->url()
        ];

        return json($result, $this->httpStatus);
    }
}