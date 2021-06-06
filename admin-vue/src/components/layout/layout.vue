<template>
  <el-container class="layout">
    <el-aside :width="collapsed ? '65px' : '250px'">
      <SideMenu class="side-menu" accordion :collapsed="collapsed" :menu-list="menuList">
        <!-- 需要放在菜单上面的内容，如Logo，写在side-menu标签内部，如下 -->
        <div class="logo-con">
          <img v-show="!collapsed" :src="maxLogo" key="max-logo" />
          <img v-show="collapsed" :src="minLogo" key="min-logo" />
        </div>
      </SideMenu>
    </el-aside>
    <el-container>
      <el-header>
        <div class="toggle" @click="collapsed = collapsed ? false : true">
          <i :class="[collapsed ? 'el-icon-s-unfold' : 'el-icon-s-fold', 'icon']"></i>
        </div>
        <div class="header-nav">
          <el-dropdown>
            <span class="el-dropdown-link">
              <el-avatar class="avatar-box" :size="34" :src="userAvatar"></el-avatar>
              <i class="el-icon-caret-bottom el-icon--right"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item>消息中心</el-dropdown-item>
              <router-link class="el-dropdown-menu__item dropdown-menu-link" to="/setting">设置</router-link>
              <el-dropdown-item divided @click.native="logout">退出系统</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
      </el-header>
      <el-main class="layout-container">
        <router-view />
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import _ from "lodash";
import SideMenu from "./components/side-menu/side-menu";
import minLogo from "@/assets/images/logo-min.jpg";
import maxLogo from "@/assets/images/logo.jpg";

export default {
  name: "layout",
  components: {
    SideMenu
  },
  data() {
    return {
      collapsed: false,
      minLogo,
      maxLogo,
      isFullscreen: false
    };
  },
  computed: {
    ...mapGetters(["menuList", "userInfo", "userAvatar"])
  },
  watch: {},
  mounted() {},
  methods: {
    ...mapActions([]),
    logout() {
      console.log("logout");
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
@import '~assets/styles/variable';

.el-container {
  height: 100%;

  .el-header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    height: 58px !important;
    background-color: #fff;
    border-bottom: 1px solid #ebebeb;
    /* box-shadow: 0 0 5px #888; */
  }

  .el-aside {
    background-color: $color-background;
  }

  .el-main {
    /deep/ .el-tabs {
      .el-tabs__header {
        margin-bottom: 0;

        .el-tabs__new-tab {
          margin-right: 10px;
        }

        .el-tabs__nav-wrap.is-scrollable {
          padding: 0 30px;
        }

        .el-tabs__nav-prev, .el-tabs__nav-next {
          padding: 0 6px;
          font-size: 18px;
        }
      }
    }
  }
}

.layout {
  height: 100%;

  .logo-con {
    box-sizing: border-box;
    height: 58px;
    padding: 10px;

    img {
      height: 38px;
      width: auto;
      display: block;
      margin: 0 auto;
    }
  }

  .toggle {
    display: inline-block;

    .icon {
      font-size: 30px;
      cursor: pointer;
    }
  }

  .header-nav {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;

    .fullscreen {
      margin-right: 10px;

      .iconfont {
        font-size: 30px;
      }
    }

    .el-dropdown-link {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;

      .avatar-box {
        border: 1px solid #348EED;
      }

      .el-icon-caret-bottom {
        font-size: 18px;
      }
    }
  }

  .layout-container {
    background: #f4f6f9;
  }
}
</style>
