const path = require('path')

const resolve = dir => {
  return path.join(__dirname, dir)
}

// 项目部署基础 (webpack 的 devServer 地址)
// process.env.NODE_ENV
// 正式环境 production
// 开发环境 development
// 默认情况下，我们假设你的应用将被部署在域的根目录下,
// 例如：https://www.my-app.com/
// 默认：'/'
// 如果您的应用程序部署在子路径中，则需要在这指定子路径
// 例如：https://www.foobar.com/my-app/
// 需要将它改为'/my-app/'
const BASE_URL = process.env.NODE_ENV === 'production'
  ? '/admin/'
  : '/'

module.exports = {
  // Project deployment base
  // By default we assume your app will be deployed at the root of a domain,
  // e.g. https://www.my-app.com/
  // If your app is deployed at a sub-path, you will need to specify that
  // sub-path here. For example, if your app is deployed at
  // https://www.foobar.com/my-app/
  // then change this to '/my-app/'
  publicPath: BASE_URL,
  outputDir: '../public/admin',
  // tweak internal webpack configuration.
  // see https://github.com/vuejs/vue-cli/blob/dev/docs/webpack.md
  // 如果你不需要使用eslint，把lintOnSave设为false即可
  lintOnSave: true,
  chainWebpack: config => {
    config.resolve.alias
      .set('@', resolve('src')) // key,value自行定义，比如.set('@@', resolve('src/components'))
      .set('api', resolve('src/api'))
      .set('assets', resolve('src/assets'))
      .set('components', resolve('src/components'))
      .set('views', resolve('src/views'))
  },
  /**
   * 调整 webpack 配置
   * https://cli.vuejs.org/zh/guide/webpack.html#%E7%AE%80%E5%8D%95%E7%9A%84%E9%85%8D%E7%BD%AE%E6%96%B9%E5%BC%8F
   * @param config
   */
  configureWebpack: config => {
    // 生产and测试环境
    const pluginsPro = []
    // 开发环境
    const pluginsDev = []
    if (process.env.NODE_ENV === 'production') {
      // 为生产环境修改配置... process.env.NODE_ENV !== 'development'
      config.plugins = [...config.plugins, ...pluginsPro]
    } else {
      // 为开发环境修改配置...
      config.plugins = [...config.plugins, ...pluginsDev]
    }
  },
  // 打包时不生成.map文件
  productionSourceMap: false,
  // 这里写你调用接口的基础路径，来解决跨域，如果设置了代理，那你本地开发环境的axios的baseUrl要写为 '' ，即空字符串
  // devServer: {
  //   proxy: 'localhost:3000'
  // }
  devServer: {
    host: 'localhost',
    // host: '0.0.0.0',
    port: 8080, // 端口号
    https: false, // https:{type:Boolean}
    open: true, // 配置自动启动浏览器
    hotOnly: true, // 热更新
    // 配置跨域处理,只有一个代理
    proxy: 'http://yicms.localhost.com/'
    // proxy: {
    //   '/apis/*': {
    //     target: 'http://10.1.36.53:8471/',
    //     changeOrigin: true,
    //     pathRewrite: {
    //       '^/apis': ''
    //     },
    //     '/ws/*': {
    //       target: 'http://10.1.36.53:8471',
    //       changeOrigin: true,
    //       // websocket支持
    //       ws: true,
    //       secure: false
    //     }
    //   }
    // }
  }
}
