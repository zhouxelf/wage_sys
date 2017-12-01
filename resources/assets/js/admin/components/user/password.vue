<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb>
                <el-breadcrumb-item>个人中心</el-breadcrumb-item>
                <el-breadcrumb-item>修改密码</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <el-row style="margin-top: 15px;">
            <el-col style="width: 400px;">
                <el-form label-width="100px" ref="form" :model="form" :rules="formRules">
                    <el-form-item label="原密码" prop="old_pwd">
                        <el-input type="password" v-model="form.old_pwd" placeholder="请输入原密码"></el-input>
                    </el-form-item>
                    <el-form-item label="新密码" prop="new_pwd">
                        <el-input type="password" v-model="form.new_pwd" placeholder="请输入新密码"></el-input>
                    </el-form-item>
                    <el-form-item label="重复新密码" prop="re_pwd">
                        <el-input type="password" v-model="form.re_pwd" placeholder="请重复输入新密码"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="handleSubmit">保存</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        data() {
            let checkPwd = (rule, value, callback) => {
                if (value.length < 5 || value.length > 20) {
                    callback(new Error('新密码长度为5~20位'));
                }
                if (value === this.form.old_pwd) {
                    callback(new Error('新密码与原密码相同'));
                }
                callback();
            };
            let checkRePwd = (rule, value, callback) => {
                if (value !== this.form.new_pwd) {
                    callback(new Error('两次输入新密码不一致'));
                }
                callback();
            };
            return {
                form: {
                    old_pwd: '',
                    new_pwd: '',
                    re_pwd: ''
                },
                formRules: {
                    old_pwd: [
                        { required: true, message: '请输入原密码', trigger: 'blur' }
                    ],
                    new_pwd: [
                        { required: true, message: '请输入新密码', trigger: 'blur' },
                        { validator: checkPwd, trigger: 'blur' }
                    ],
                    re_pwd: [
                        { required: true, message: '请重复输入新密码', trigger: 'blur' },
                        { validator: checkRePwd, trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            handleSubmit() {
                let self = this;
                self.$refs.form.validate((valid) => {
                    if (valid) {
                        axios.post('/admin/user/password', {
                            old_pwd: self.form.old_pwd,
                            new_pwd: self.form.new_pwd,
                            re_pwd: self.form.re_pwd
                        }).then(function (res) {
                            if (res.data.status === 0) {
                                self.$message({
                                    title: '成功',
                                    message: res.data.msg,
                                    type: 'success'
                                });
                                self.form.old_pwd = '';
                                self.form.new_pwd = '';
                                self.form.re_pwd = '';
                            } else {
                                self.$message({
                                    title: '失败',
                                    message: res.data.msg,
                                    type: 'error'
                                });
                            }
                        });
                    }
                });
            }
        }
    }
</script>