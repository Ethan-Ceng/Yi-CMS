<template>
  <div class="aside-container">
    <el-menu
      class="side-menu"
      router
      @open="handleOpen"
      @close="handleClose"
      :collapse="isCollapse"
    >
      <template v-for="item in menuList">
        <!-- 多子菜单（一个或多个，一个时由 showSubMenu 确定是否展示父菜单）-->
        <template v-if="item.children && item.children.length >= 1">
          <!-- 直接展示子菜单 只有一个资源菜单，判断是否直接展示 -->
          <el-menu-item
            v-if="showChildren(item)"
            :index="item.children[0].name"
            :route="item.children[0]"
            :key="`menu-${item.children[0].name}`"
          >
            <i class="el-icon-menu"></i>
            <template #title>{{
              item.children[0].meta.title || "导航一"
            }}</template>
          </el-menu-item>
          <!-- 多级展示 -->
          <SubMenu v-else :parentItem="item" :key="`menu-${item.name}`" />
        </template>
        <!-- 无子菜单 children null -->
        <el-menu-item
          v-else
          :index="item.name"
          :route="item"
          :key="`menu-${item.name}`"
        >
          <i class="el-icon-menu"></i>
          <template #title>{{ item.meta.title || "导航一" }}</template>
        </el-menu-item>
      </template>
    </el-menu>
  </div>
</template>

<script>
import MenuList from "@/router/routers.js";
import SubMenu from "./submenu.vue";
export default {
  name: "SideMenu",
  components: {
    SubMenu,
  },
  props: {
    isCollapse: {
      type: Boolean,
      default: () => {
        return false;
      },
    },
  },
  data() {
    return {
      menuList: MenuList,
    };
  },
  methods: {
    showChildren(item) {
      if (item.children && item.children.length >= 1) {
        return false;
      }
      return true;
      // return item.children && (item.children.length > 1 || (item.meta && item.meta.showSubMenu))
    },
    handleOpen(key, keyPath) {
      console.log(key, keyPath);
    },
    handleClose(key, keyPath) {
      console.log(key, keyPath);
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.aside-container {
  background-color: #efefef;
}
</style>
