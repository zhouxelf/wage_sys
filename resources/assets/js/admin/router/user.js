// 用户
export default [
    {
        path: '/user/password',
        component: resolve =>void(require(['../components/user/password.vue'], resolve))
    },
    {
        path: '/user/list',
        component: resolve =>void(require(['../components/user/List.vue'], resolve))
    },
]