import { getToken, loadUserInfo } from '@/libs/cache'

const state = {
  // User State
  userInfo: loadUserInfo(),
  token: getToken(),
  access: '',
}

export default state
