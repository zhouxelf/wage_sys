<template>
    <div>
        <h1>Test</h1>
        <div id="myChart" :style="{width: '100%', height: '300px'}"></div>
    </div>
</template>

<script>
    import echarts from 'echarts';

    export default {
        data() {
            return {
                title: 'ECharts 入门示例'
            }
        },
        mounted() {
            let myChart = echarts.init(document.getElementById('myChart'));
            myChart.setOption({
                title: {
                    text: this.title
                },
                tooltip: {},
                xAxis: {
                    data: ['衬衫', '羊毛衫', '雪纺衫', '裤子', '高跟鞋', '袜子']
                },
                yAxis: {},
                series: [{
                    name: '销量',
                    type: 'bar',
                    data: [5, 20, 36, 10, 10, 20]
                }]
            });
        }
    }
</script>

<style scoped>

</style>