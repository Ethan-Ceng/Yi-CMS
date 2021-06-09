import Layout from "@/components/layout/index.vue";

/**
 * meta 除了原生参数外可配置的参数:
 * meta: {
 *  title: { String|Number|Function }
 *         显示在侧边栏、面包屑和标签栏的文字
 *         使用'{{ 多语言字段 }}'形式结合多语言使用，例子看多语言的路由配置;
 *         可以传入一个回调函数，参数是当前路由对象，例子看动态路由和带参路由
 *  hideInMenu: (false) 设为true后在左侧菜单不会显示该页面选项
 *  notCache: (false) 设为true后页面不会缓存
 *  access: (null) 可访问该页面的权限数组，当前路由设置的权限会影响子路由
 *  icon: (-) 该页面在左侧菜单、面包屑和标签导航处显示的图标，如果是自定义图标，需要在图标名称前加下划线'_'
 * Auth
 *  beforeCloseName: (-) 设置该字段，则在关闭当前tab页时会去'@/router/before-close.js'里寻找该字段名对应的方法，作为关闭前的钩子函数
 * }
 */

const routes = [
  {
    path: "/login",
    name: "login",
    meta: {
      title: "Login - 登录",
      hideInMenu: false,
    },
    component: () => import("@/views/login/index.vue"),
  },
  {
    path: "/",
    name: "_home",
    redirect: "/home",
    component: Layout,
    meta: {
      hideInMenu: false,
      title: "首页",
      notCache: true,
      icon: "el-icon-s-home",
    },
    children: [
      {
        path: "/home",
        name: "home",
        meta: {
          hideInMenu: false,
          title: "首页",
          notCache: true,
          icon: "md-home",
        },
        component: () => import("@/views/Home.vue"),
      },
      {
        path: "/dashboard",
        name: "dashboard",
        meta: {
          hideInMenu: true,
          title: "仪表盘",
          notCache: true,
          icon: "md-home",
        },
        component: Layout,
        children: [
          {
            path: "/home3",
            name: "_home3",
            meta: {
              hideInMenu: false,
              title: "首页3",
              notCache: true,
              icon: "md-home",
            },
            component: () => import("@/views/Home.vue"),
          },
          {
            path: "/dashboard3",
            name: "_dashboard3",
            meta: {
              hideInMenu: true,
              title: "仪表盘3",
              notCache: true,
              icon: "md-home",
            },
            component: () => import("@/views/Home.vue"),
          },
        ],
      },
    ],
  },
  // {
  //   path: "/about",
  //   name: "About",
  //   // route level code-splitting
  //   // this generates a separate chunk (about.[hash].js) for this route
  //   // which is lazy-loaded when the route is visited.
  //   component: () =>
  //     import(/* webpackChunkName: "about" */ "@/views/About.vue"),
  // },
];

export default routes;
