<template>
<!-- 指处理有子菜单情况 -->
  <el-submenu :index="parentItem.name" :router="true">
    <!-- 组名 -->
    <template v-if="parentItem.meta.icon" slot="title">
      <i v-if="parentItem.meta.icon" :class="parentItem.meta.icon"></i>
      <span slot="title">{{parentItem.meta.title || ''}}</span>
    </template>
    <span v-else slot="title">{{parentItem.meta.title || ''}}</span>

    <template v-for="item in parentItem.children">
      <!-- 多子菜单（一个或多个，一个时由 showSubMenu 确定是否展示父菜单）-->
      <template v-if="item.children && item.children.length >= 1">
        <!-- 直接展示子菜单 -->
        <el-menu-item v-if="showChildren(item)" :index="item.children[0].name" :route="item.children[0]" :key="`menu-${item.children[0].name}`">
          <i v-if="item.children[0].meta.icon" :class="item.children[0].meta.icon"></i>
          <span slot="title">{{item.children[0].meta.title || ''}} </span>
        </el-menu-item>
        <!-- 多级展示 -->
        <menu-item v-else :parentItem="item" :key="`menu-${item.name}`"/>
      </template>
      <!-- 无子元素 children null -->
      <el-menu-item v-else :index="item.name" :route="item" :key="`menu-${item.name}`">
        <i v-if="item.meta.icon" :class="item.meta.icon"></i>
        <span slot="title">{{item.meta.title || ''}} </span>
      </el-menu-item>

    </template>
  </el-submenu>
</template>

<script>
  import mixin from './mixin'

  export default {
    name: 'menu-item',
    mixins: [mixin],
    props: {
      parentItem: {
        type: Object,
        default: () => {}
      }
    }
  }
</script>
