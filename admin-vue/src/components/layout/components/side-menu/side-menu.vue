<template>
  <div class="side-menu-wrapper">
    <slot></slot>
    <el-scrollbar style="height: calc(100% - 58px);" wrapStyle="overflow-x: hidden;">
      <el-menu
        :collapse="collapsed"
        default-active="2"
        background-color="#343a40"
        text-color="#ffffff"
        active-text-color="#007bff"
        router
        @open="handleOpen"
        @close="handleClose"
        @select="handleSelect"
      >
        <template v-for="item in menuList">
          <!-- 多子菜单（一个或多个，一个时由 showSubMenu 确定是否展示父菜单）-->
          <template v-if="item.children && item.children.length >= 1">
            <!-- 直接展示子菜单 -->
            <el-menu-item
              v-if="showChildren(item)"
              :index="item.children[0].name"
              :route="item.children[0]"
              :key="`menu-${item.children[0].name}`"
            >
              <i v-if="item.children[0].meta.icon" :class="item.children[0].meta.icon"></i>
              <span slot="title">{{item.children[0].meta.title || ''}}</span>
            </el-menu-item>
            <!-- 多级展示 -->
            <menu-item v-else :parentItem="item" :key="`menu-${item.name}`" />
          </template>
          <!-- 无子菜单 children null -->
          <el-menu-item v-else :index="item.name" :route="item" :key="`menu-${item.name}`">
            <i v-if="item.meta.icon" :class="item.meta.icon"></i>
            <span slot="title">{{item.meta.title || ''}}</span>
          </el-menu-item>
        </template>
      </el-menu>
    </el-scrollbar>
  </div>
</template>

<script>
import MenuItem from "./menu-item";
import mixin from "./mixin";
import Config from "@/config/index";

export default {
  name: "side-menu",
  mixins: [mixin],
  props: {
    menuList: {
      type: Array,
      default() {
        return [];
      }
    },
    collapsed: {
      type: Boolean
    }
  },
  data() {
    return {
      openedNames: []
    };
  },
  created() {},
  computed: {},
  watch: {
    watch: {
    '$route' (newRoute) {
      this.updateOpenName(newRoute.name)
    }
  },
  },
  methods: {
    handleOpen (key, keyPath) {
      console.log(key, keyPath);
    },
    handleClose (key, keyPath) {
      console.log(key, keyPath);
    },
    handleSelect (index, indexPath) {
      console.log("点击选中", index, indexPath);
    },
    getOpenedNamesByActiveName (name) {
      return this.$route.matched
        .map(item => item.name)
        .filter(item => item !== name);
    },
    updateOpenName (name) {
      if (name === Config.homeName) {
        this.openedNames = [];
      } else {
        this.openedNames = this.getOpenedNamesByActiveName(name);
      }
    }
  },
  components: {
    MenuItem
  }
};
</script>

<style lang="scss" scoped>
>>> .el-menu {
  border-right: none;
}

.side-menu-wrapper {
  height: 100%;
  width: 100%;
  user-select: none;

  .menu-collapsed {
    padding-top: 10px;

    .ivu-dropdown {
      width: 100%;

      .ivu-dropdown-rel a {
        width: 100%;
      }
    }

    .ivu-tooltip {
      width: 100%;

      .ivu-tooltip-rel {
        width: 100%;
      }

      .ivu-tooltip-popper .ivu-tooltip-content {
        .ivu-tooltip-arrow {
          border-right-color: #fff;
        }

        .ivu-tooltip-inner {
          background: #fff;
          color: #495060;
        }
      }
    }
  }

  a.drop-menu-a {
    display: inline-block;
    padding: 6px 15px;
    width: 100%;
    text-align: center;
    color: #495060;
  }
}

.menu-title {
  padding-left: 6px;
}
</style>
