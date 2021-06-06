<template>
  <div class="login">
    <el-card class="login-con">
      <div slot="header">
        <span>欢迎登录</span>
      </div>
      <el-form ref="loginForm" size="large" :model="form" :rules="rules" @keydown.enter.native="handleSubmit">
        <el-form-item prop="userName">
          <el-input prefix-icon="el-icon-user" v-model="form.email" placeholder="请输入邮箱"></el-input>
        </el-form-item>
        <el-form-item prop="password">
          <el-input prefix-icon="el-icon-lock" type="password" v-model="form.password" placeholder="请输入密码">
          </el-input>
        </el-form-item>
        <el-form-item>
          <el-button style="width: 100%;" @click="handleSubmit" type="primary" long>登录</el-button>
        </el-form-item>
      </el-form>
    </el-card>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import Config from '@/config/index'
  import { login } from '@/api/user'

  export default {
    data () {
      return {
        form: {
          userName: 'super_admin',
          password: ''
        },
        rules: {
          userName: [
            {
              required: true,
              message: '请输帐号',
              trigger: 'blur'
            },
            {
              min: 4,
              max: 20,
              message: '长度在 4 到 20 个字符',
              trigger: 'blur'
            }
          ],
          password: [
            {
              required: true,
              message: '请选择密码',
              trigger: 'change'
            }
          ]

        }
      }
    },
    methods: {
      ...mapActions([
        'handleUserLogin'
      ]),
      handleSubmit: async function () {
        const { email, password } = this.form
        const { resultMsg, resultCode, data } = await login({ email, password })
        console.log(resultMsg, resultCode, data)
        if (resultCode === 0) {
          this.handleUserLogin({
            ...data
          })
          this.$router.push({
            name: Config.homeName
          })
          this.$message.success(resultMsg)
        } else {
          this.$message.error(resultMsg || '系统错误')
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  .login {
    width: 100%;
    height: 100%;
    background-image: url('../../assets/images/login-bg.jpg');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;

    .login-con {
      width: 420px;
    }
  }
</style>
