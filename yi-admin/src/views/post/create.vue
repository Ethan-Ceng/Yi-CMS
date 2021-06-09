<template>
  <div>
    <div id="editorElem"></div>
    <button v-on:click="getContent">查看内容</button>
  </div>
</template>

<script>
import E from "wangeditor";

export default {
  name: "create",
  data() {
    return {
      editor: null,
      editorContent: "<p>Content of the editor.</p>",
      // editorConfig: {
      //   // The configuration of the editor.
      // }
    };
  },
  created() {},
  mounted() {
    this.editor = new E("#editorElem");
    this.editor.config.onchange = (html) => {
      this.editorContent = html;
    };
    this.editor.create();
  },
  methods: {
    getContent: function () {
      alert(this.editorContent);
    },
  },
};
</script>

<style scoped>
</style>
