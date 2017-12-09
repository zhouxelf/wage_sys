// 工资
export default [
    {
        path: '/wage/list',
        component: resolve =>void(require(['../components/wage/List.vue'], resolve))
    },
    {
        path: '/wage/detail',
        component: resolve =>void(require(['../components/wage/Detail.vue'], resolve))
    },
    {
        path: '/wage/import',
        component: resolve =>void(require(['../components/wage/Import.vue'], resolve))
    }
]