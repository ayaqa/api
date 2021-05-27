import { createRouter, createWebHashHistory, RouteRecordRaw } from "vue-router";

import Layout from "../layout/index.vue";

const routes: Array<RouteRecordRaw> = [
    {
        path: "/",
        name: "home",
        component: Layout,
        redirect: "/intro",
        children: [
            {
                path: "/intro",
                name: "intro",
                component: () =>
                    import(/* webpackChunkName: "intro" */ "../views/intro.vue"),
                meta: {
                    title: "message.intro",
                },
            },
        ]
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
