import * as types from './mutation-types'
import { setToken, saveUserInfo } from '@/libs/cache'

// 用户登陆设置用户信息
export const handleUserLogin = function ({ commit }, userData) {
  commit(types.SET_USER, userData)
  setToken(userData.token)
  saveUserInfo(userData)
}
