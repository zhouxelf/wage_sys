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
    {
        path: '/user/edit',
        component: resolve =>void(require(['../components/user/Edit.vue'], resolve))
    },
    {
        path: '/user/import',
        component: resolve =>void(require(['../components/user/Import.vue'], resolve))
    }
]