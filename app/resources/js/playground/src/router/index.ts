import { createRouter, createWebHashHistory, RouteRecordRaw } from "vue-router";

import { 
    mdiHome,
    mdiCheckboxMarked,
    mdiFlask,
    mdiFileDocumentOutline
} from '@quasar/extras/mdi-v5';

import AppLayout from "../layout/app/Layout.vue";

import attr from "@/constants/data-attr";

const TYPE_ITEM = 'item';
const TYPE_SEPARATOR = 'separator';
const TYPE_HEADER = 'header';

const sideMenu = [
    { type: TYPE_ITEM, name: 'home', icon: mdiHome},
    { type: TYPE_SEPARATOR },
    { type: TYPE_HEADER, title: 'sidemenu.simpleHeader' },
    { type: TYPE_ITEM, name: 'checkboxes', icon: mdiCheckboxMarked},
    { type: TYPE_SEPARATOR },
];

const topMenu = [
    { type: TYPE_ITEM, name: 'configure', icon: mdiFlask },
    { type: TYPE_ITEM, name: 'status', icon: mdiFileDocumentOutline },
]

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'root',
        component: AppLayout,
        redirect: '/home',
        children: [
            {
                path: '/home',
                name: 'home',
                component: () => import(/* webpackChunkName: "home" */ '@/views/Home.vue'),
                meta: {
                    title: 'sidemenu.home',
                    ayaqa: attr.sideMenuHome
                },
            },
            {
                path: '/checkboxes',
                name: 'checkboxes',
                component: () => import(/* webpackChunkName: "checkboxes" */ '@/views/Checkboxes.vue'),
                meta: {
                    title: 'sidemenu.checkboxes',
                    ayaqa: attr.sideMenuCheckboxes
                },
            },
            {
                path: '/configure',
                name: 'configure',
                component: () => import(/* webpackChunkName: "configure" */ '@/views/app/Configure.vue'),
                meta: {
                    title: 'menu.configure',
                    ayaqa: attr.menuConfigureItem
                },
            },
            {
                path: '/status',
                name: 'status',
                component: () => import(/* webpackChunkName: "configure" */ '@/views/app/Status.vue'),
                meta: {
                    title: 'menu.status',
                    ayaqa: attr.menuStatusItem
                },
            }
        ]
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export {
    sideMenu,
    topMenu,

    TYPE_ITEM,
    TYPE_SEPARATOR,
    TYPE_HEADER
}

export default router;
