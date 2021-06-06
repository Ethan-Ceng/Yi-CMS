<template>
  <div class="wrapper">
    <el-card class="box-card">
      <div slot="header">
        <el-page-header @back="() => {this.$router.replace({ path: '/member/list' })}" content="详情页面">
        </el-page-header>
      </div>

      <el-form :model="dialogData" status-icon :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
        <el-form-item prop="email">
          <el-input type="hidden" v-model="dialogData.email"></el-input>
          <el-upload
            class="avatar-uploader"
            action="/admin/upload/avatar"
            :show-file-list="false"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload">
            <img v-if="imageUrl" :src="imageUrl" class="avatar">
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item>

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

    </el-card>
  </div>
</template>

<script>
  import { listAllAPI, createAPI, updateAPI } from '@/api/adminUser'

  export default {
    name: 'create-edit',
    data () {
      return {
        tableData: [],
        currentPage: 1,
        pageSize: 10,
        totalPage: 1,
        imageUrl: '', // 图片地址
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
      // 上传
      handleAvatarSuccess(res, file) {
        this.imageUrl = URL.createObjectURL(file.raw);
      },
      beforeAvatarUpload(file) {
        const isJPG = file.type === 'image/jpeg';
        const isLt2M = file.size / 1024 / 1024 < 2;

        if (!isJPG) {
          this.$message.error('上传头像图片只能是 JPG 格式!');
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!');
        }
        return isJPG && isLt2M;
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

  .avatar-uploader {
    .el-upload {
      border: 1px dashed #d9d9d9;
      border-radius: 6px;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }
    .el-upload:hover {
      border-color: #409EFF;
    }
    .avatar-uploader-icon {
      font-size: 28px;
      color: #8c939d;
      width: 178px;
      height: 178px;
      line-height: 178px;
      text-align: center;
    }
    .avatar {
      width: 178px;
      height: 178px;
      display: block;
    }
  }
</style>
