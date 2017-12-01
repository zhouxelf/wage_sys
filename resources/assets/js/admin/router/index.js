import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
let myRouter = [];

// 用户模块
import  user  from "./user"
user.forEach(function (obj) {
    myRouter.push(obj);
});

// 工资模块
import  wage  from  "./wage"
wage.forEach(function (obj) {
    myRouter.push(obj);
});

export default new VueRouter({
    saveScrollPosition: true,
    routes: myRouter
});