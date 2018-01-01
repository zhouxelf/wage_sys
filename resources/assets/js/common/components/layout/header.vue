<template>
    <div class="gm-header">
        <div class="title">
            {{ app_name }}
        </div>
        <el-menu default-active="1" class="el-menu-cls" mode="horizontal" @select='handleSelect'>
            <el-submenu index="user">
                <template slot="title">个人中心</template>
                <el-menu-item index="/user/password">修改密码</el-menu-item>
            </el-submenu>
            <el-menu-item index='logout'>退出系统</el-menu-item>
        </el-menu>
        <div style="clear:both;"></div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                app_name: window.App.appName
            }
        },
        methods: {
            handleSelect(key, keyPath) {
                if (key === "logout") {
                    window.location.href = "/logout";
                } else {
                    this.$router.push(key);
                }
            }
        }
    }
</script>

<style>
    .gm-header > ul {
        background-color: transparent !important;
    }

    .gm-header > ul > li,
    .gm-header .el-submenu__title {
        color: white;
    }

    .gm-header > ul > li:hover,
    .gm-header .el-submenu__title:hover {
        background-color: transparent !important;
        border-bottom-color: rgba(255, 255, 255, 0.5) !important;
    }

    .gm-header {
        background-color: rgb(69, 91, 140);
    }

    .gm-header .title {
        float: left;
        margin: 0 30px;
        line-height: 60px;
        font-size: 24px;
        color: #fff;
    }

    .gm-header .el-menu {
        float: right;
        margin-right: 20px;
    }

    .point {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: #fff;
        border-radius: 10px;
        line-height: 40px;
        vertical-align: middle;
    }
</style>
