import type from '../type'

const state = {
    total: 20
}
const getters = {
    getA (state) { return state.total }
}
const actions = {
    add ({commit,state}) {
        state.total++
        commit(type.TEST_MUTATIONS)
    }
}
const mutations = {
    des (state) {
        state.total--
    },
    [type.TEST_MUTATIONS](state){
        console.log(state)
    }
}
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}