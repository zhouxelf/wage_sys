<template>
    <div>
        <h2>欢迎您，{{ lastWage.name }}</h2>
        <el-card v-show="flag">
            <h2>你最近一个月的工资情况如下：</h2>
            <el-row>
                <el-col :span="3">
                    <h3>工号：{{ lastWage.code }}</h3>
                    <h3>应发工资：{{ lastWage.wage_should }}</h3>
                    <h3>底薪：{{ lastWage.wage_base }}</h3>
                    <h3>津贴：{{ lastWage.wage_allowance }}</h3>
                    <h3>奖金：{{ lastWage.wage_bonus }}</h3>
                </el-col>
                <el-col :span="3">
                    <h3>姓名：{{ lastWage.name }}</h3>
                    <h3>扣发工资：{{ lastWage.wage_garnishment }}</h3>
                    <h3>水电费：{{ lastWage.water_electric }}</h3>
                    <h3>暖气费：{{ lastWage.heating_costs }}</h3>
                    <h3>房租：{{ lastWage.house_rent }}</h3>
                    <h3>个人所得税：{{ lastWage.income_tax }}</h3>
                </el-col>
                <el-col :span="4">
                    <h3>工资年月：{{ lastWage.wage_year }}{{ formatMonth }}</h3>
                    <h2 style="color: #843534">实发工资：{{ lastWage.wage_actual }}</h2>
                </el-col>
                <el-col :span="7">
                    <div id="Chart" :style="{width: '350px', height: '300px'}"></div>
                </el-col>
                <el-col :span="7">
                    <div id="Chart2" :style="{width: '350px', height: '300px'}"></div>
                </el-col>
            </el-row>
            <hr style="margin-top: 50px;">
            <el-row>
                <div style="margin-top: 50px;">
                    <div id="myChart" :style="{width: '1200px', height: '500px'}"></div>
                </div>
            </el-row>
        </el-card>
        <h2 v-show="!flag">系统中没有您的工资信息，请等待管理员录入工资信息信息后再来查询</h2>
    </div>
</template>

<script>
    import echarts from 'echarts';

    export default {
        data() {
            return {
                flag: false,
                wages: [],
                wages_ym: [],
                wages_should: [],
                wages_garnishment: [],
                wages_actual: [],
                lastWage: {
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
            setLineChart() {
                let myChart = echarts.init(document.getElementById('myChart'));
                let Chart = echarts.init(document.getElementById('Chart'));
                let Chart2 = echarts.init(document.getElementById('Chart2'));
                myChart.setOption({
                    title: {
                        text: '近月工资曲线图'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data:['应发工资','扣发工资','实发工资']
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    toolbox: {
                        feature: {
                            saveAsImage: {}
                        }
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: this.wages_ym
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name:'应发工资',
                            type:'line',
                            data:this.wages_should
                        },
                        {
                            name:'扣发工资',
                            type:'line',
                            data:this.wages_garnishment
                        },
                        {
                            name:'实发工资',
                            type:'line',
                            data:this.wages_actual
                        }
                    ]
                });
                Chart.setOption({
                    title : {
                        text: '应发工资',
                        x:'center'
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        data: ['底薪','津贴','奖金']
                    },
                    series : [
                        {
                            name: '人民币',
                            type: 'pie',
                            radius : '55%',
                            center: ['50%', '60%'],
                            data:[
                                {value:this.lastWage.wage_base, name:'底薪'},
                                {value:this.lastWage.wage_allowance, name:'津贴'},
                                {value:this.lastWage.wage_bonus, name:'奖金'}
                            ],
                            itemStyle: {
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }
                    ]
                });
                Chart2.setOption({
                    title : {
                        text: '扣发工资',
                        x:'center'
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        data: ['水电费','暖气费','房租','个人所得税']
                    },
                    series : [
                        {
                            name: '人民币',
                            type: 'pie',
                            radius : '55%',
                            center: ['50%', '60%'],
                            data:[
                                {value:this.lastWage.water_electric, name:'水电费'},
                                {value:this.lastWage.heating_costs, name:'暖气费'},
                                {value:this.lastWage.house_rent, name:'房租'},
                                {value:this.income_tax, name:'个人所得税'}
                            ],
                            itemStyle: {
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }
                    ]
                });
            },
            getLastWage() {
                if (this.wages.length > 0) {
                    this.lastWage = this.wages[this.wages.length-1];
                    this.flag = true;
                }
            },
            getFormatData() {
                let wages_temp = this.wages;
                let wages_ym_temp = [];
                let wages_should_temp = [];
                let wages_garnishment_temp = [];
                let wages_actual_temp = [];
                for (let i = 0; i < wages_temp.length; i++) {
                    if (wages_temp[i].wage_month.length < 2) {
                        wages_ym_temp.push(wages_temp[i].wage_year + '0' + wages_temp[i].wage_month);
                    } else {
                        wages_ym_temp.push(wages_temp[i].wage_year + wages_temp[i].wage_month);
                    }
                    wages_should_temp.push(wages_temp[i].wage_should);
                    wages_garnishment_temp.push(wages_temp[i].wage_garnishment);
                    wages_actual_temp.push(wages_temp[i].wage_actual);
                }
                this.wages_ym = wages_ym_temp;
                this.wages_should = wages_should_temp;
                this.wages_garnishment = wages_garnishment_temp;
                this.wages_actual = wages_actual_temp;
            },
            getData() {
                let self = this;
                axios.get('/admin/wage/gets').then((res) => {
                    console.log(res.data);
                    if (res.data.code === 0 ) {
                        self.wages = res.data.result;
                        self.getLastWage();
                        self.getFormatData();
                        self.setLineChart();
                    } else {
                        self.$message({
                            message: res.data.msg,
                            type: 'warning'
                        });
                    }
                });
            }
        },
        computed: {
            // 格式化月份
            formatMonth() {
                if (this.lastWage.wage_month.length < 2) {
                    return '0' + this.lastWage.wage_month;
                } else {
                    return this.lastWage.wage_month;
                }
            }
        },
        mounted() {
            this.getData();
        }
    }
</script>