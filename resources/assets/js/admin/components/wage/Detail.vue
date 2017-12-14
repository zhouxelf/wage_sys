<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="el-icon-arrow-left gm-home" @click="$router.go(-1)" style="cursor: pointer;margin-top: -2px;"></i>
            <el-breadcrumb>
                <el-breadcrumb-item>工资管理</el-breadcrumb-item>
                <el-breadcrumb-item>工资详情</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <el-card style="width: 800px;">
            <el-row>
                <el-col :span="8">
                    <h3>工号：{{ wage.code }}</h3><br>
                    <h2>应发工资：{{ wage.wage_should }}</h2>
                    <h3>底薪：{{ wage.wage_base }}</h3>
                    <h3>津贴：{{ wage.wage_allowance }}</h3>
                    <h3>奖金：{{ wage.wage_bonus }}</h3>
                </el-col>
                <el-col :span="8">
                    <h3>姓名：{{ wage.name }}</h3><br>
                    <h2>扣发工资：{{ wage.wage_garnishment }}</h2>
                    <h3>水电费：{{ wage.water_electric }}</h3>
                    <h3>暖气费：{{ wage.heating_costs }}</h3>
                    <h3>房租：{{ wage.house_rent }}</h3>
                    <h3>个人所得税：{{ wage.income_tax }}</h3>
                </el-col>
                <el-col :span="8">
                    <h3>工资年月：{{ wage.wage_year }}{{ wage.wage_month }}</h3><br>
                    <h1>实发工资：{{ wage.wage_actual }}</h1>
                </el-col>
            </el-row>
        </el-card>
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
                    wage_base: 0,    // 底薪
                    wage_allowance: 0,    // 津贴
                    wage_bonus: 0,    // 奖金
                    wage_should: 0,    // 应发工资
                    water_electric: 0,    // 水电费
                    heating_costs: 0,    // 暖气费
                    house_rent: 0,    // 房租
                    income_tax: 0,    // 个人所得税
                    wage_garnishment: 0,    // 扣发工资
                    wage_actual: 0    // 实发工资
                },
            }
        },
        methods: {
            getData(id) {
                let self = this;
                let param = {
                    id: id
                };
                axios.get('/admin/wage/get', {
                    params: param
                }).then((res) => {
                    console.log(res);
                    if (res.data.code === 0 ) {
                        self.wage = res.data.result;
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