import { getMenuByRouter } from '@/libs/util'
import routers from '@/router/routers'

export const menuList = state => {
  return getMenuByRouter(routers, state.userInfo.access)
}
export const userInfo = state => state.userInfo
export const userAvatar = state => state.userInfo.avatarImgPath
