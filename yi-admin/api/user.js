import request from '@/libs/request'

export const login = ({ email, password }) => {
  const data = {
    email,
    password
  }
  return request({
    method: 'post',
    url: 'admin/login',
    data
  })
}

export const logout = (token) => {
  return request({
    url: 'logout',
    method: 'post'
  })
}

// 会员列表
export const getUserListAPI = (params) => {
  return request({
    url: 'logout',
    method: 'post',
    params: params
  })
}
