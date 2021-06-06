<template>
  <div class="wrapper">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>分类管理</span>
        <el-button-group size="small" style="float: right; padding: 3px 0">
          <el-button icon="el-icon-plus" @click="dialogVisible = true"
            >添加</el-button
          >
          <el-button icon="el-icon-delete">回收站</el-button>
        </el-button-group>
      </div>
      <div class="card-body">
        <el-row>
          <el-col :span="12">
            <el-tree
              :data="tableData"
              show-checkbox
              node-key="id"
              default-expand-all
              :expand-on-click-node="false"
              :render-content="renderContent"
            >
            </el-tree>
          </el-col>
          <!-- 新增分类 -->
          <el-col :span="9" :offset="3">
            <el-form
              :model="dialogData"
              status-icon
              :rules="rules"
              ref="ruleForm"
              label-width="100px"
              class="demo-ruleForm"
            >
              <el-form-item label="上级分类" prop="pidName">
                <el-input disabled v-model="dialogData.pidName"></el-input>
              </el-form-item>
              <el-form-item prop="pid">
                <el-input type="hidden" v-model="dialogData.pid"></el-input>
              </el-form-item>
              <el-form-item label="分类名" prop="name">
                <el-input v-model="dialogData.name"></el-input>
              </el-form-item>
              <el-form-item label="简介" prop="desription">
                <el-input
                  type="desription"
                  v-model="dialogData.desription"
                  autocomplete="off"
                ></el-input>
              </el-form-item>
              <el-form-item>
                <el-button
                  v-if="dialogData.id"
                  type="primary"
                  @click="submitUpdateForm('ruleForm')"
                  >提 交</el-button
                >
                <el-button
                  v-else
                  type="primary"
                  @click="submitAddForm('ruleForm')"
                  >添 加</el-button
                >
                <el-button @click="dialogVisible = false">取 消</el-button>
              </el-form-item>
            </el-form>
          </el-col>
        </el-row>
      </div>
    </el-card>
    <!-- 操作弹窗 -->
    <el-dialog
      title="添加顶级分类"
      :visible.sync="dialogVisible"
      :destroy-on-close="true"
      width="500"
      @close="handleDialogClose"
    >
      <div class="dialog-body"></div>
    </el-dialog>
  </div>
</template>

<script>
import { listAllAPI, createAPI, updateAPI } from "@/api/category";

export default {
  name: "category",
  data() {
    return {
      // table 数据
      tableData: [
        {
          id: 1,
          label: "一级 1",
          children: [
            {
              id: 4,
              label: "二级 1-1",
              children: [
                {
                  id: 9,
                  label: "三级 1-1-1",
                },
                {
                  id: 10,
                  label: "三级 1-1-2",
                },
              ],
            },
          ],
        },
        {
          id: 2,
          label: "一级 2",
          children: [
            {
              id: 5,
              label: "二级 2-1",
            },
            {
              id: 6,
              label: "二级 2-2",
            },
          ],
        },
        {
          id: 3,
          label: "一级 3",
          children: [
            {
              id: 7,
              label: "二级 3-1",
            },
            {
              id: 8,
              label: "二级 3-2",
            },
          ],
        },
      ],
      currentPage: 1,
      pageSize: 10,
      totalPage: 1,
      // 弹窗数据
      dialogVisible: false,
      dialogData: {
        id: "",
        pid: 0,
        pidName: "根目录",
        name: "",
        desription: "",
      },
      // 新增分类校验规则
      rules: {
        name: [
          {
            required: true,
            message: "请输入分类名",
            trigger: "blur",
          },
        ],
        desription: [
          {
            validator: (rule, value, callback) => {
              if (value === "") {
                callback(new Error("请输入备注"));
              } else {
                callback();
              }
            },
            trigger: "blur",
          },
        ],
      },
    };
  },
  watch: {
    filterText(val) {
      this.$refs.tree.filter(val);
    },
  },
  created() {
    this.featchTableData();
  },
  methods: {
    append(data) {
      const newChild = { id: id++, label: "testtest", children: [] };
      if (!data.children) {
        this.$set(data, "children", []);
      }
      data.children.push(newChild);
    },

    remove(node, data) {
      const parent = node.parent;
      const children = parent.data.children || parent.data;
      const index = children.findIndex((d) => d.id === data.id);
      children.splice(index, 1);
    },

    renderContent(h, { node, data, store }) {
      return (
        <span class="custom-tree-node">
          <span>{node.label}</span>
          <span>
            <el-button
              size="mini"
              type="text"
              on-click={() => this.append(data)}
            >
              添加子分类
            </el-button>
            <el-button
              size="mini"
              type="text"
              on-click={() => this.remove(node, data)}
            >
              删除
            </el-button>
          </span>
        </span>
      );
    },

    async featchTableData() {
      const { resultMsg, resultCode, data } = await listAllAPI({
        page: this.currentPage,
        pageSize: this.pageSize,
      });
      if (resultCode === 0 && data) {
        this.tableData = data;
        // this.totalPage = data.total;
        // this.pageSize = data.per_page;
        // this.currentPage = data.current_page;
      } else {
        this.tableData = [];
        this.$message.error(resultMsg || "系统错误");
      }
    },

    submitAddForm: function (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          createAPI(this.dialogData).then((res) => {
            const { resultMsg, resultCode, data } = res;
            if (resultCode === 0 && data) {
              this.$message.success("添加成功");
            } else {
              this.$message.error(resultMsg || "系统错误");
            }
          });
        }
      });
    },
    submitUpdateForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          const { resultMsg, resultCode, data } = updateAPI(
            this.dialogData
          );
          if (resultCode === 0 && data) {
          } else {
            this.$message.error(resultMsg || "系统错误");
          }
        } else {
          return false;
        }
      });
    },
    handleDialogClose() {
      this.dialogData = {
        id: "",
        name: "",
        desription: "",
      };
      console.log(this.dialogData);
    },
    handleEdit(row) {
      this.dialogVisible = true;
      this.dialogData = {
        id: row.id,
        name: row.name,
      };
    },
    handleDelete(index, row) {
      console.log(index, row);
    },
  },
};
</script>

<style lang="scss" scoped>
.custom-tree-node {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 14px;
  padding-right: 8px;
}
</style>
