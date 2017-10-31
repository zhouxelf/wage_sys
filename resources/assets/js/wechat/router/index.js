import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: 'wechat',
            path: '/wechat',
            component: resolve => void(require(['../components/WeChat.vue'], resolve))
        }
    ]
});