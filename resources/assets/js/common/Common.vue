<template>
    <div>
        <pageHeader></pageHeader>
        <div style="/*position:fixed;*/top:60px;bottom:0;left:0;right:0;padding:20px 30px;">
            <div class="page-content">
                <div style="padding:10px 20px 35px;background-color:#fff;">
                    <router-view></router-view>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import pageHeader from './components/layout/header.vue'

    export default {
        components: {
            pageHeader
        }
    }
</script>

<style>
    /* 减小 select 对象 loading 动画大小 */
    .el-select .el-loading-spinner .circular {
        width: 24px!important;
        height: 24px!important;
    }

    .el-select .el-loading-spinner {
        margin-top: -10px!important;
    }
</style>