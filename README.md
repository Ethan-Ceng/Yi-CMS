# Yi-CMS
===============
> Yi CMS。基于ThinkPHP，一套简单基础的企业站系统，便捷企业网上推广。方便拓展，二次开发。内涵内容管理，商城，UCG等模块。 前台，后台管理，小程序，App接口，前后端分离独立。


     
## 系统设计架构
- 1.入口 `index.php` 多应用模式
- 2.路由 `route` 路由控制访问接口地址，请求方法。方法内二次判断。
- 3.中间层架构 `middleware && BaseController` 并列结构（建议通过中间件处理）
- 4.`Validate` 校验器控制入参正确性
- 5.业务逻辑处理 `controller && service` 并列结构 
- 6.`model`层由 `ORM` 模型处理
- 7.`Exception` 错误自定义处理
- 8.数据返回，统一格式`resultCode | resultMsg | data`
- 9.后台管理使用Vue搭建的的前后端分离，admin-vue目录下，无需部署，方便二次开发



## RESTFul API
> 开启路由强制模式，必须走路由
> 并且抽离 BaseController 结偶逻辑

```$javascript
/**
 * notify
 * 返回数据提中不能使用message字段，与TP6框架中冲突
 * vendor/topthink/framework/src/think/exception/Handle.php
 * message must string Handle strpos($message, ':')
 */
[
    'resultCode' => Int 1,
    'resultMsg' => 'String 消息内容',
    'data' => 'Array 查询数据'
]
```

### resultCode 返回值说明

- http status 400,200
- 2** 请求成功
- 4** 请求错误，妨碍服务器处理
- 400 错误请求
- 401 未授权，请求要求身份验证
- 403 禁止，服务器拒绝请求
- 404 未找到，服务器找不到请求资源
- 500 （服务器内部错误） 服务器遇到错误，无法完成请求。

> 请求成功返回状态码一律200，查询结果为空返回数据 `data` 为空

|resultCode | 状态|
|:----:|:----|
| 999 | 内部异常 |
| 0 | 正常 |
| 1 | 异常 |


ThinkPHP 6.0
===============

> 运行环境要求PHP7.1+。

## 安装

~~~
composer create-project topthink/think tp 6.0.*-dev
~~~

如果需要更新框架使用
~~~
composer update topthink/framework
~~~

## 文档

[完全开发手册](https://www.kancloud.cn/manual/thinkphp6_0/content)

## 参与开发

请参阅 [ThinkPHP 核心框架包](https://github.com/top-think/framework)。

## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2019 by ThinkPHP (http://thinkphp.cn)

All rights reserved。

ThinkPHP® 商标和著作权所有者为上海顶想信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)

## 系统设计

每个对象基础方法命名
- getList 列表，支持对应字段搜索
- /:id url 获取对应id资源
- create 创建
- update 更新
- delete 删除

RESTFul 请求方法 主要使用 Get，Post
- POST 创建
- PUT 更新
- GET 查询
- DELETE 删除

## 数据库 默认设计
|字段 | 数值| 表示|
|:----:|:----|:----|
|status| 1 | 正常 其他表示其他状态，不维护是否删除，删除状态由 delete_time 维护 |
| create_time | int | 创建时间 |
| update_time | int | 更新时间 |
| delete_time | int | 软删除时间 不用做查询使用，只用作记录 |


### 基础信息

- area 国家行政规划基础数据
- file 网站资源网盘（TODO: 网盘资源管理功能）
- banner 网址轮播图管理（TODO: 待完善）
- banner_item 轮播图
- theme 专题（TODO: 待完善）

### 企业中心
- admin_user 管理员会员
- post 企业站文章
- post_category 企业站文章分类

### 会员中心 user（member） 表
> 会员中心，解决会员信息信息，处理所有登陆，会员管理对外相关功能，微信等第三方登录。

- user 会员表
- user_address 会员收货地址



### 文章中心


### 商品中心
- product 商品表
- product_category 商品分类表

### 交易中心
- order 订单表

### 支付中心






## 技术点

- 反作弊场景
- 消息队列
- redis 集群
- 负载均衡
- 限流
- 服务容灾
- 系统降级
- 性能优化
- 商品抢购
- 并发锁
- 分布式 session
- 服务评估
- 压力测试
- 排队机制
- 问题挖掘
- 支付服务化