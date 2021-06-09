import request from '@/libs/request'

export const listAllAPI = ({page, pageSize}) => {
  const params = {page, pageSize}
  return request({
    method: 'get',
    url: '/admin/category/getCategoryTree',
    params: params
  })
}

export const createAPI = (User) => {
  return request({
    method: 'post',
    url: '/admin/category/create',
    data: User
  })
}

export const updateAPI = (User) => {
  return request({
    method: 'post',
    url: '/admin/category/update',
    data: User
  })
}
