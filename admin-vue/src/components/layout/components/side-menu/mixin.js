import {showTitle} from '@/libs/util'

export default {
  methods: {
    showTitle(item) {
      return showTitle(item, this)
    },
    showChildren(item) {
      if (item.children) {
        if (item.children.length > 1 || (item.meta && item.meta.showSubMenu)) {
          return false
        }
      }
      return true
      // return item.children && (item.children.length > 1 || (item.meta && item.meta.showSubMenu))
    },
    getNameOrHref(item, children0) {
      return item.href ? `isTurnByHref_${item.href}` : (children0 ? item.children[0].name : item.name)
    }
  }
}
