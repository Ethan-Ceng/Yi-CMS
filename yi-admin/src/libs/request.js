/**
 * 统一捕获接口报错 : 用的axios内置的拦截器
 * 弹窗提示: 引入 Element UI的Message组件
 * 报错重定向: 路由钩子
 * 基础鉴权: 服务端过期时间戳和token,还有借助路由的钩子
 * 表单序列化: 我这边直接用qs(npm模块),你有时间也可以自己写
 */

import router from "@/router/index";
import axios from "axios";
import config from "@/config";
import { getToken, clearToken, clearUser } from "@/libs/cache";
import { Message } from "element-ui";

/**
 * axios 请求的baseUrl
 * @type {string}
 */
const baseUrl =
  process.env.NODE_ENV === "development"
    ? config.baseUrl.dev
    : config.baseUrl.pro;
const ERR_EXPIRES = 10000;
const TIMEOUT = 10000;

const Request = axios.create({
  baseURL: baseUrl,
  timeout: TIMEOUT,
  withCredentials: false, // 是否允许带cookie这些
  headers: {
    // 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
    // 'Content-Type': 'application/json;charset=utf-8'
  },
});

// POST传参序列化(添加请求拦截器)
Request.interceptors.request.use(
  (config) => {
    // 若是有做鉴权token , 就给头部带上token
    // 若是需要跨站点,存放到 cookie 会好一点,限制也没那么多,有些浏览环境限制了 localstorage 的使用
    // 这里localStorage一般是请求成功后我们自行写入到本地的,因为你放在vuex刷新就没了
    // 一些必要的数据写入本地,优先从本地读取
    const token = getToken();
    // token 添加到http header
    config.headers = {
      ...config.headers,
      token: token,
    };
    return config;
  },
  (error) => {
    // error 的回调信息,看贵公司的定义
    Message({
      //  饿了么的消息弹窗组件,类似toast
      showClose: true,
      message: error && error.data.error.msg,
      type: "error",
    });
    return Promise.reject(error.data.error.msg);
  }
);

// 返回状态判断(添加响应拦截器)
Request.interceptors.response.use(
  (response) => {
    /**
     * 响应数据 response
     * 返回 服务器结果集 data 部分
     * code，message，result 没返回
     */
    const { status, data } = response;
    // 如果返回的状态码为200，说明接口请求成功，可以正常拿到数据
    // 否则的话抛出错误
    if (status === 200) {
      return Promise.resolve(data);
    } else {
      // 对 code 判断是否正确
      return Promise.reject(response);
    }
  },
  (error) => {
    const {
      response,
      response: { status },
    } = error;
    console.log(error, response, status);
    if (status) {
      /**
       * 检查错误码
       */
      switch (status) {
        /**
         * unauthorized
         * 401: 未登录 (token 无效)
         * 未登录则跳转登录页面，并携带当前页面的路径
         * 在登录成功后返回当前页面，这一步需要在登录页操作
         */
        case 401:
          clearToken();
          clearUser();
          router.push("/login");
          Message.error("登录过期，请重新登录");
          break;

        /**
         * forbidden
         * 403 服务器禁止
         */
        case 403:
          Message.error("禁止访问");
          break;

        /**
         * 404 not found
         * 表示在服务器上没有找到请求的资源
         */
        case 404:
          Message.error("登录过期，请重新登录");
          break;
        // 其他错误，直接抛出错误提示
        default:
          Message.error(error.response.data.message);
      }
      // return Promise.reject(error.response)
    }

    /**
     * 捕获错误信息，并保存起来
     * @type {AxiosResponse | AxiosInterceptorManager<AxiosResponse> | any}
     */
    //  1.判断请求超时
    if (
      error.code === "ECONNABORTED" &&
      error.message.indexOf("timeout") !== -1
    ) {
      // console.log('根据你设置的timeout/真的请求超时 判断请求现在超时了，你可以在这里加入超时的处理方案')
    }

    let errorInfo = {};
    if (!response) {
      const {
        request: { statusText, status },
        config,
      } = JSON.parse(JSON.stringify(error));
      errorInfo = {
        statusText,
        status,
        request: { responseURL: config.url },
      };
    } else {
      console.log("errorInfo:", response);
      const { statusText, status } = JSON.parse(JSON.stringify(response));
      errorInfo = {
        statusText,
        status,
        // request: { responseURL: config.url }
      };
      // Element Message
      Message.error(`${status}, ${statusText}`);
    }

    return Promise.reject(error);
  }
);

export default Request;
