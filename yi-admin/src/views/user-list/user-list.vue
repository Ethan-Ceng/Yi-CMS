<template>
  <div class="wrapper">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>会员管理</span>
        <el-button style="float: right; padding: 3px 0" type="text" @click="() => {this.$router.push({ path: '/member/create' })}">添加会员</el-button>
      </div>
      <div class="card-body">
        <el-table border
                  :data="tableData"
                  style="width: 100%">

          <el-table-column label="用户名">
            <template slot-scope="scope">
              <el-avatar :size="64" src="https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg"></el-avatar>
              <span>{{scope.row.username}}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="邮箱"
            prop="email">
          </el-table-column>
          <el-table-column
            label="更新时间"
            prop="create_time">
          </el-table-column>
          <el-table-column
            label="状态"
            prop="status">
          </el-table-column>
          <el-table-column fixed="right" label="操作" width="160">
            <template slot-scope="scope">
              <el-button
                size="mini"
                style="margin-right: 15px"
                @click="handleEdit(scope.row)">编辑
              </el-button>
              <el-popconfirm
                @onConfirm="handleDelete(scope.$index, scope.row)"
                confirmButtonType="warning"
                icon="el-icon-info"
                iconColor="red"
                title="确定删除？"
              >
                <el-button size="mini" type="danger" slot="reference">删除</el-button>
              </el-popconfirm>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <div class="card-footer">
        <el-pagination
          @size-change="pageSizeChange"
          @current-change="pageCurrentChange"
          :current-page="currentPage"
          :page-sizes="[10, 20, 50, 100]"
          :page-size="pageSize"
          layout="total, sizes, prev, pager, next, jumper"
          :total="totalPage">
        </el-pagination>
      </div>
    </el-card>

    <!-- 操作弹窗 -->
    <el-dialog
      title="提示"
      :visible.sync="dialogVisible"
      :destroy-on-close="true"
      width="500"
      @close="handleDialogClose">
      <div class="dialog-body">
        <el-form :model="dialogData" status-icon :rules="rules" ref="ruleForm" label-width="100px"
                 class="demo-ruleForm">
          <el-form-item label="邮箱" prop="email">
            <el-input v-model="dialogData.email"></el-input>
          </el-form-item>
          <el-form-item label="密码" prop="password">
            <el-input type="password" v-model="dialogData.password" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item label="确认密码" prop="confirmPassword">
            <el-input type="password" v-model="dialogData.confirmPassword" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button v-if="dialogData.id" type="primary" @click="submitUpdateForm('ruleForm')">提 交</el-button>
            <el-button v-else type="primary" @click="submitAddForm('ruleForm')">添 加</el-button>
            <el-button @click="dialogVisible = false">取 消</el-button>
          </el-form-item>
        </el-form>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import { listAllAPI, createAPI, updateAPI } from '@/api/adminUser'

  export default {
    name: 'user-list',
    data () {
      return {
        tableData: [],
        currentPage: 1,
        pageSize: 10,
        totalPage: 1,
        dialogVisible: false,
        dialogData: {
          id: '',
          email: '',
          password: '',
          confirmPassword: ''
        },
        rules: {
          email: [
            {
              required: true,
              message: '请输入邮箱地址',
              trigger: 'blur'
            },
            {
              type: 'email',
              message: '请输入正确的邮箱地址',
              trigger: ['blur', 'change']
            }
          ],
          password: [
            {
              validator: (rule, value, callback) => {
                if (value === '') {
                  callback(new Error('请输入密码'))
                } else {
                  if (this.dialogData.password !== '') {
                    this.$refs.ruleForm.validateField('confirmPassword')
                  }
                  callback()
                }
              },
              trigger: 'blur'
            }
          ],
          confirmPassword: [
            {
              validator: (rule, value, callback) => {
                if (value === '') {
                  callback(new Error('请再次输入密码'))
                } else if (value !== this.dialogData.password) {
                  callback(new Error('两次输入密码不一致!'))
                } else {
                  callback()
                }
              },
              trigger: 'blur'
            }
          ],
        }
      }
    },
    created () {
      this.featchTableData()
    },
    computed: {},
    watch: {},
    methods: {
      pageSizeChange (val) {
        this.pageSize = val
        this.featchTableData()
      },
      pageCurrentChange (val) {
        this.currentPage = val
        this.featchTableData()
      },
      async featchTableData () {
        const { resultMsg, resultCode, data } = await listAllAPI({
          page: this.currentPage,
          pageSize: this.pageSize
        })
        if (resultCode === 0 && data) {
          this.tableData = data.data
          this.totalPage = data.total
          this.pageSize = data.per_page
          this.currentPage = data.current_page
        } else {
          this.$message.error(resultMsg || '系统错误')
        }
      },
      handleDialogClose () {
        this.dialogData = {
          id: '',
          email: '',
          password: '',
          confirmPassword: ''
        }
        console.log(this.dialogData)
      },
      submitAddForm: function (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            createAPI(this.dialogData).then(res => {
              const { resultMsg, resultCode, data } = res
              if (resultCode === 0 && data) {
                this.$message.success('添加成功')
                this.dialogVisible = false
                this.featchTableData()
              } else {
                this.$message.error(resultMsg || '系统错误')
              }
            })
          }
        })
      },
      submitUpdateForm (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            const { resultMsg, resultCode, data } = updateAPI(this.dialogData)
            if (resultCode === 0 && data) {

            } else {
              this.$message.error(resultMsg || '系统错误')
            }
          } else {
            return false
          }
        })
      },
      handleEdit (row) {
        this.dialogVisible = true
        this.dialogData = {
          id: row.id,
          email: row.email,
        }
      },
      handleDelete (index, row) {
        console.log(index, row)
      }
    },
    components: {}
  }
</script>

<style lang="scss" scoped>
  .card-footer {
    padding-top: 20px;
    text-align: right;
  }
</style>
