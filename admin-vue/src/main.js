import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'

/**
 * @description 样式相关
 */
import 'assets/styles/index.scss'

/**
 * @description 按需加载 element 组件
 */
Vue.use(ElementUI, {
  size: 'small',
  zIndex: 3000
})


// todo 注册指令、插件、
/**
 * @description 过滤器
 */
// import filters from './libs/filters'

/**
 * @description 过滤器注册
 */
// Vue.prototype.filters = filters
// Object.keys(filters).forEach(key => {
//   Vue.filter(key, filters[key])
// })

/**
 * @description 生产环境关掉提示
 */
Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
