<template>
  <el-container>
    <SideMenu :isCollapse="isCollapse"></SideMenu>
    <el-container>
      <el-header class="header-container">
        <div class="collapse-btn" v-on:click="toggleCollapse(!isCollapse)">
          <i v-show="!isCollapse" class="el-icon-s-fold"></i>
          <i v-show="isCollapse" class="el-icon-s-unfold"></i>
        </div>
      </el-header>
      <el-main>
        <router-view />
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
import SideMenu from "./components/side-menu/index.vue";
export default {
  name: "Layout",
  components: {
    SideMenu,
  },
  data() {
    return {
      isCollapse: false,
    };
  },
  methods: {
    toggleCollapse(status) {
      console.log(status);
      this.isCollapse = status;
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.header-container {
  .collapse-btn {
    font-size: 32px;
  }
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
