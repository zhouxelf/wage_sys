<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="el-icon-arrow-left gm-home" @click="$router.go(-1)" style="cursor: pointer;margin-top: -2px;"></i>
            <el-breadcrumb>
                <el-breadcrumb-item>用户管理</el-breadcrumb-item>
                <el-breadcrumb-item>学生编辑</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <el-row style="margin-top: 15px;">
            <el-col style="width: 500px;">
                <el-form :model="user" label-width="100px">
                    <el-form-item label="工号">
                        <el-input v-model="user.code" placeholder="请输入工号" label-width="100px"></el-input>
                    </el-form-item>
                    <el-form-item label="姓名">
                        <el-input v-model="user.name" placeholder="请输入姓名"></el-input>
                    </el-form-item>
                    <el-form-item label="性别">
                        <el-radio-group v-model="user.sex">
                            <el-radio label="男">男</el-radio>
                            <el-radio label="女">女</el-radio>
                        </el-radio-group>
                    </el-form-item>
                    <el-form-item label="手机号">
                        <el-input v-model="user.phone" placeholder="请输入手机号"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="onSave">保 存</el-button>
                        <router-link to="/user/list">
                            <el-button>取 消</el-button>
                        </router-link>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    id: 0,
                    code: '',
                    name: '',
                    sex: '男',
                    phone: ''
                },
            }
        },
        methods: {
            test() {
                let code = this.user.code.trim();
                let name = this.user.name.trim();
                let phone = this.user.phone.trim();

                let reg_code = /^[0-9]{5,20}$/;
                let reg_name = /^[\u4E00-\u9FA5]{2,4}$/;
                let reg_phone = /^1[3|5|7|8]\d{9}$/;

                if (!reg_code.test(code)) {
                    this.$message({
                        message: '工号错误，请重新填写',
                        type: 'warning'
                    });
                } else if (!reg_name.test(name)) {
                    this.$message({
                        message: '姓名错误，请重新填写',
                        type: 'warning'
                    });
                } else if (!reg_phone.test(phone)) {
                    this.$message({
                        message: '手机号错误，请重新填写',
                        type: 'warning'
                    });
                } else {
                    return true;
                }
            },
            onSave() {
                if (this.test()) {
                    let self = this;
                    axios.post('/admin/user/edit', self.user).then((res) => {
                        console.log(res);
                        if (res.data.code === 0) {
                            self.$message({
                                message: res.data.msg,
                                type: 'success'
                            });
                            this.$router.push({
                                path: '/user/list'
                            })
                        } else {
                            self.$message({
                                message: res.data.msg,
                                type: 'warning'
                            });
                        }
                    });
                }
            },
            getData(id) {
                let self = this;
                let param = {
                    id: id
                };
                axios.get('/admin/user/get', {
                    params: param
                }).then((res) => {
                    console.log(res);
                    if (res.data.code === 0 ) {
                        self.user = res.data.result;
                    } else {
                        self.$message({
                            message: res.data.msg,
                            type: 'warning'
                        });
                    }
                });
            }
        },
        mounted() {
            let id = Number.parseInt(this.$route.query.id);
            if (id > 0) {
                // 加载对象
                this.getData(id);
            }
        }
    }
</script>