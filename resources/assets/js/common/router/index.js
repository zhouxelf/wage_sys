import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            path: '/',
            component: resolve => void(require(['../components/wage/Detail.vue'], resolve))
        },
        {
            path: '/user/password',
            component: resolve =>void(require(['../components/user/password.vue'], resolve))
        },
    ]
});