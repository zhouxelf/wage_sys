<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="el-icon-arrow-left gm-home" @click="$router.go(-1)" style="cursor: pointer;margin-top: -2px;"></i>
            <el-breadcrumb>
                <el-breadcrumb-item>工资管理</el-breadcrumb-item>
                <el-breadcrumb-item>工资详情</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <!--<el-row style="margin-top: 15px;">-->
            <!--<el-col style="width: 500px;">-->
                <!--<el-form :model="wage" label-width="100px">-->
                    <!--<el-form-item label="工号">-->
                        <!--<el-input v-model="wage.code" placeholder="请输入工号" @blur="getUserName(wage.code)"></el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="姓名">-->
                        <!--<el-input v-model="wage.name" placeholder="请输入姓名" disabled></el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="底薪">-->
                        <!--<el-input v-model="wage.wage_base" value="number" placeholder="请输入底薪">-->
                            <!--<template slot="append">.00</template>-->
                        <!--</el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="津贴">-->
                        <!--<el-input v-model="wage.wage_allowance" placeholder="请输入津贴">-->
                            <!--<template slot="append">.00</template>-->
                        <!--</el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="奖金">-->
                        <!--<el-input v-model="wage.wage_bonus" placeholder="请输入奖金">-->
                            <!--<template slot="append">.00</template>-->
                        <!--</el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="应发工资">-->
                        <!--<el-input v-model="wage.wage_should" placeholder="请输入应发工资" size="large" disabled>-->
                            <!--<template slot="append">.00</template>-->
                        <!--</el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="水电费">-->
                        <!--<el-input v-model="wage.water_electric" placeholder="请输入水电费">-->
                            <!--<template slot="prepend">-</template>-->
                            <!--<template slot="append">.00</template>-->
                        <!--</el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="暖气费">-->
                        <!--<el-input v-model="wage.heating_costs" placeholder="请输入暖气费">-->
                            <!--<template slot="prepend">-</template>-->
                            <!--<template slot="append">.00</template>-->
                        <!--</el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="房租">-->
                        <!--<el-input v-model="wage.house_rent" placeholder="请输入房租">-->
                            <!--<template slot="prepend">-</template>-->
                            <!--<template slot="append">.00</template>-->
                        <!--</el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="个人所得税">-->
                        <!--<el-input v-model="wage.income_tax" placeholder="请输入个人所得税">-->
                            <!--<template slot="prepend">-</template>-->
                            <!--<template slot="append">.00</template>-->
                        <!--</el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="扣发工资">-->
                        <!--<el-input v-model="wage.wage_garnishment" placeholder="请输入扣发工资" size="large" disabled>-->
                            <!--<template slot="prepend">-</template>-->
                            <!--<template slot="append">.00</template>-->
                        <!--</el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="实发工资">-->
                        <!--<el-input v-model="wage.wage_actual" placeholder="请输入实发工资" size="large" disabled>-->
                            <!--<template slot="append">.00</template>-->
                        <!--</el-input>-->
                    <!--</el-form-item>-->
                    <!--&lt;!&ndash;<el-form-item>&ndash;&gt;-->
                        <!--&lt;!&ndash;<el-button type="primary" @click="onSave">保 存</el-button>&ndash;&gt;-->
                        <!--&lt;!&ndash;<router-link to="/user/list">&ndash;&gt;-->
                            <!--&lt;!&ndash;<el-button>取 消</el-button>&ndash;&gt;-->
                        <!--&lt;!&ndash;</router-link>&ndash;&gt;-->
                    <!--&lt;!&ndash;</el-form-item>&ndash;&gt;-->
                <!--</el-form>-->
            <!--</el-col>-->
        <!--</el-row>-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                wage: {
                    id: 0,
                    code: '',
                    name: '',
                    wage_year: '',
                    wage_month: '',
                    wage_base: 0.00,    // 底薪
                    wage_allowance: 0.00,    // 津贴
                    wage_bonus: 0.00,    // 奖金
                    wage_should: 0.00,    // 应发工资
                    water_electric: 0.00,    // 水电费
                    heating_costs: 0.00,    // 暖气费
                    house_rent: 0.00,    // 房租
                    income_tax: 0.00,    // 个人所得税
                    wage_garnishment: 0.00,    // 扣发工资
                    wage_actual: 0.00    // 实发工资
                },
            }
        },
        methods: {
            getUserName(val) {
                let self = this;
                let code = val.trim();
                if (code === '') return;
                let reg_code = /^[0-9]{5,20}$/;
                if (!reg_code.test(code)) {
                    self.$message({
                        message: '工号错误，请重新填写',
                        type: 'warning'
                    });
                } else {
                    let param = {
                        code: code
                    };
                    axios.get('/admin/user/getUserName', {
                        params: param
                    }).then((res) => {
                        if (res.data.code === 0 ) {
                            self.wage.name = res.data.result;
                        } else {
                            self.$message({
                                message: res.data.msg,
                                type: 'warning'
                            });
                        }
                    });
                }
            },
            // test() {
            //     let code = this.user.code.trim();
            //     let name = this.user.name.trim();
            //     let phone = this.user.phone.trim();
            //
            //     let reg_code = /^[0-9]{5,20}$/;
            //     let reg_name = /^[\u4E00-\u9FA5]{2,4}$/;
            //     let reg_phone = /^1[3|5|7|8]\d{9}$/;
            //
            //     if (!reg_code.test(code)) {
            //         this.$message({
            //             message: '工号错误，请重新填写',
            //             type: 'warning'
            //         });
            //     } else if (!reg_name.test(name)) {
            //         this.$message({
            //             message: '姓名错误，请重新填写',
            //             type: 'warning'
            //         });
            //     } else if (!reg_phone.test(phone)) {
            //         this.$message({
            //             message: '手机号错误，请重新填写',
            //             type: 'warning'
            //         });
            //     } else {
            //         return true;
            //     }
            // },
            // onSave() {
            //     if (this.test()) {
            //         let self = this;
            //         axios.post('/admin/user/edit', self.user).then((res) => {
            //             console.log(res);
            //             if (res.data.code === 0) {
            //                 self.$message({
            //                     message: res.data.msg,
            //                     type: 'success'
            //                 });
            //                 this.$router.push({
            //                     path: '/user/list'
            //                 })
            //             } else {
            //                 self.$message({
            //                     message: res.data.msg,
            //                     type: 'warning'
            //                 });
            //             }
            //         });
            //     }
            // },
        //     getData(id) {
        //         let self = this;
        //         let param = {
        //             id: id
        //         };
        //         axios.get('/admin/user/get', {
        //             params: param
        //         }).then((res) => {
        //             console.log(res);
        //             if (res.data.code === 0 ) {
        //                 self.user = res.data.result;
        //             } else {
        //                 self.$message({
        //                     message: res.data.msg,
        //                     type: 'warning'
        //                 });
        //             }
        //         });
        //     }
        // },
        // mounted() {
        //     let id = Number.parseInt(this.$route.query.id);
        //     if (id > 0) {
        //         // 加载对象
        //         this.getData(id);
        //     }
        }
    }
</script>