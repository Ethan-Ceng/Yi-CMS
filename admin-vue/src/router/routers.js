import Layout from '@/components/layout/layout'
import parentView from '@/components/parent-view/parent-view'

/**
 * iview-admin中meta除了原生参数外可配置的参数:
 * meta: {
 *  title: { String|Number|Function }
 *         显示在侧边栏、面包屑和标签栏的文字
 *         使用'{{ 多语言字段 }}'形式结合多语言使用，例子看多语言的路由配置;
 *         可以传入一个回调函数，参数是当前路由对象，例子看动态路由和带参路由
 *  hideInMenu: (default: false) 设为true后在左侧菜单不会显示该页面选项
 *  showSubMenu: (default: false) 设为true后如果该路由只有一个子路由，在菜单中也会显示该父级菜单 否则渲染成一级菜单
 *  notCache: (default: false) 设为true后页面不会缓存
 *  access: (default: null) 可访问该页面的权限数组，当前路由设置的权限会影响子路由
 *  icon: (default: -) 该页面在左侧菜单、面包屑和标签导航处显示的图标，如果是自定义图标，需要在图标名称前加下划线'_'
 *  href: 'https://xxx' (default: null) 用于跳转到外部连接
 *  beforeCloseName: (-) 设置该字段，则在关闭当前tab页时会去'@/router/before-close.js'里寻找该字段名对应的方法，作为关闭前的钩子函数
 * }
 */

export default [
  {
    path: '/login',
    name: 'login',
    meta: {
      title: 'Login - 登录',
      hideInMenu: true
    },
    component: () => import('@/views/login/login.vue')
  },
  {
    path: '/',
    name: '_home',
    redirect: '/dashboard',
    component: Layout,
    meta: {
      hideInMenu: false,
      title: '首页',
      notCache: true,
      icon: 'el-icon-s-home'
    },
    children: [
      {
        path: '/dashboard',
        name: 'dashboard',
        meta: {
          title: '仪表盘',
          notCache: true,
          icon: 'icon iconfont icon-dashboard'
        },
        component: () => import('@/views/single-page/home')
      }
    ]
  },
  {
    path: '/setting',
    name: 'setting',
    redirect: '/setting/site',
    meta: {
      showAlways: true,
      title: '设置',
      icon: 'el-icon-s-home'
    },
    component: Layout,
    children: [
      {
        path: '/setting/site',
        name: 'setting_site',
        meta: {
          title: '网站设置',
          icon: 'el-icon-s-home',
          beforeCloseName: 'before_close_normal'
        },
        component: () => import('@/views/single-page/home')
      },
      {
        path: '/setting/system',
        name: 'setting_system',
        meta: {
          title: '系统设置',
          icon: 'el-icon-s-home',
          beforeCloseName: 'before_close_normal'
        },
        component: () => import('@/views/single-page/home')
      }
    ]
  },
  {
    path: '/admin',
    name: 'admin',
    redirect: '/adminList',
    meta: {
      title: '管理员管理',
      icon: 'iconfont icon-dashboard'
    },
    component: Layout,
    children: [
      {
        path: '/adminList',
        name: 'admin-list',
        meta: {
          title: '管理员管理',
          icon: 'iconfont icon-dashboard'
        },
        component: () => import('@/views/admin-list/admin-list')
      },
    ]
  },
  {
    path: '/member',
    name: 'member',
    redirect: '/member/list',
    meta: {
      title: '会员管理',
      icon: 'iconfont icon-dashboard'
    },
    component: Layout,
    children: [
      {
        path: '/member/list',
        name: 'member_list',
        meta: {
          title: '会员管理',
          icon: 'el-icon-user-solid'
        },
        component: () => import('@/views/user-list/user-list')
      },
      {
        path: '/member/create',
        name: 'member_create',
        meta: {
          title: '创建会员',
          icon: 'el-icon-user-solid',
          hideInMenu: true
        },
        component: () => import('@/views/user-list/create-edit')
      }
    ]
  },
  {
    path: '/category',
    name: '_categories',
    redirect: '/category/manage',
    component: Layout,
    meta: {
      hideInMenu: false,
      title: '分类管理',
      notCache: true,
      icon: 'el-icon-s-home'
    },
    children: [
      {
        path: '/category/manage',
        name: 'categories',
        meta: {
          title: '分类管理',
          notCache: true,
          icon: 'icon iconfont icon-dashboard'
        },
        component: () => import('@/views/category/category')
      }
    ]
  },
  {
    path: '/post',
    name: 'post',
    redirect: '/dashboard',
    meta: {
      title: '文章管理',
      icon: 'iconfont icon-dashboard'
    },
    component: Layout,
    children: [
      {
        path: '/post/category',
        name: 'post_category',
        meta: {
          title: '文章分类',
          icon: 'iconfont icon-dashboard'
        },
        component: () => import('@/views/post/category')
      },
      {
        path: '/post/list',
        name: 'post_list',
        meta: {
          title: '所有文章',
          icon: 'iconfont icon-dashboard'
        },
        component: () => import('@/views/post/list')
      },
      {
        path: '/post/create',
        name: 'post_create',
        meta: {
          title: '写文章',
          icon: 'iconfont icon-dashboard'
        },
        component: () => import('@/views/post/create')
      }
    ]
  },
  {
    path: '/yun',
    name: 'yun',
    meta: {
      showSub: true,
      icon: 'iconfont icon-appstore',
      title: '网盘'
    },
    component: Layout,
    children: [
      {
        path: '/yun/all',
        name: 'yun_all',
        meta: {
          icon: 'iconfont icon-sever',
          title: '所有文件'
        },
        component: () => import('@/views/single-page/home')
      },
      {
        path: '/yun/picture',
        name: 'yun_picture',
        meta: {
          icon: 'iconfont icon-sever',
          title: '图片'
        },
        component: () => import('@/views/single-page/home')
      },
      {
        path: '/yun/book',
        name: 'yun_book',
        meta: {
          icon: 'iconfont icon-sever',
          title: '电子书'
        },
        component: () => import('@/views/single-page/home')
      },
      {
        path: '/yun/music',
        name: 'yun_music',
        meta: {
          icon: 'iconfont icon-sever',
          title: '音乐'
        },
        component: () => import('@/views/single-page/home')
      },
      {
        path: '/yun/video',
        name: 'yun_video',
        meta: {
          icon: 'iconfont icon-sever',
          title: '视频'
        },
        component: () => import('@/views/single-page/home')
      },
      {
        path: '/yun/upload',
        name: 'yun_upload',
        meta: {
          icon: 'iconfont icon-sever',
          title: '上传文件'
        },
        component: () => import('@/views/single-page/home')
      }
    ]
  },
  {
    path: '',
    name: 'doc',
    meta: {
      title: '文档',
      href: 'https://lison16.github.io/iview-admin-doc/#/',
      icon: 'el-icon-collection'
    }
  },
  {
    path: '/multilevel',
    name: 'multilevel',
    meta: {
      icon: 'el-icon-menu',
      title: '多级菜单'
    },
    component: Layout,
    children: [
      {
        path: 'level_2_1',
        name: 'level_2_1',
        meta: {
          icon: 'md-funnel',
          title: '二级-1'
        },
        component: () => import('@/views/multilevel/level-2-1.vue')
      },
      {
        path: 'level_2_2',
        name: 'level_2_2',
        meta: {
          icon: 'md-funnel',
          showSubMenu: true,
          title: '二级-2'
        },
        component: parentView,
        children: [
          {
            path: 'level_2_2_1',
            name: 'level_2_2_1',
            meta: {
              icon: 'md-funnel',
              title: '三级'
            },
            component: () => import('@/views/multilevel/level-2-2/level-3-1.vue')
          }
        ]
      },
      {
        path: 'level_2_3',
        name: 'level_2_3',
        meta: {
          icon: 'md-funnel',
          title: '二级-3'
        },
        component: () => import('@/views/multilevel/level-2-3.vue')
      }
    ]
  },
  {
    path: '/401',
    name: 'error_401',
    meta: {
      hideInMenu: true
    },
    component: () => import('@/views/error-page/401.vue')
  },
  {
    path: '/500',
    name: 'error_500',
    meta: {
      hideInMenu: true
    },
    component: () => import('@/views/error-page/500.vue')
  },
  {
    path: '*',
    name: 'error_404',
    meta: {
      hideInMenu: true
    },
    component: () => import('@/views/error-page/404.vue')
  }
]
