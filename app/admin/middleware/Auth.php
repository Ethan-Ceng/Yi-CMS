<?php
/**
 * 权限管理，全部通过中间件处理，
 * 不通过BaseController，AuthController处理权限问题
 * 所有控制器专心做业务处理，业务中需要考虑安全新问题
 */

namespace app\admin\middleware;


use app\common\exception\TokenException;

class Auth
{
    /**
     * 处理请求
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        // 前置中间件
        $token = $request->header('token');
        if (!$token) {
            throw new TokenException(['message' => '请求Token缺省！']);
        }
        $vars = cache($token);
        if (!$vars) {
            throw new TokenException();
        }
        // 后置中间件
        return $next($request);
    }
}