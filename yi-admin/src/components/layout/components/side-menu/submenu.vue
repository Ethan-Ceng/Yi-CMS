<template>
  <el-submenu :index="parentItem.name" :router="true">
    <!-- 菜单组名 -->
    <template #title>
      <i class="el-icon-menu"></i>
      <span>{{ parentItem.meta.title || "菜单组名" }}</span>
    </template>

    <!-- 多子菜单（一个或多个，一个时由 showSubMenu 确定是否展示父菜单）-->
    <template v-for="item in parentItem.children">
      <!-- 多子菜单（一个或多个，一个时由 showSubMenu 确定是否展示父菜单）-->
      <template v-if="item.children && item.children.length >= 1">
        <!-- 直接展示子菜单 -->
        <el-menu-item
          v-if="showChildren(item)"
          :index="item.children[0].name"
          :route="item.children[0]"
          :key="`menu-${item.children[0].name}`"
        >
          <i
            v-if="item.children[0].meta.icon"
            :class="item.children[0].meta.icon"
          ></i>
          <template #title>{{ item.children[0].meta.title || "" }} </template>
        </el-menu-item>
        <!-- 多级展示 -->
        <sub-menu v-else :parentItem="item" :key="`menu-${item.name}`" />
      </template>
      <!-- 无子元素 children null -->
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
  </el-submenu>
</template>

<script>
export default {
  name: "subMenu",
  props: {
    parentItem: Object,
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
  mounted() {
    console.log(this.parentItem.children.length);
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.aside-container {
  background-color: #efefef;
}
</style>
