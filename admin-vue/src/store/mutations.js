import * as types from './mutation-types'
import { setToken } from '@/libs/cache'

const mutations = {
  [types.SET_USER] (state, userInfo) {
    state.avatarImgPath = userInfo.avatarImgPath
    state.userId = userInfo.userId
    state.userName = userInfo.userName
    state.access = userInfo.access
    state.token = userInfo.token
    setToken(userInfo.token)
  }
}

export default mutations
