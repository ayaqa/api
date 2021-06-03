import { computed } from 'vue';
import { RouteRecordRaw } from "vue-router";

import { 
    TYPE_ITEM, 
} from '@/router'

const findAndGetMeta = (name: string, root: Array<RouteRecordRaw>) => {
    let obj: any = {};

    root.forEach((routerItem) => {
        if (routerItem.name === name) {
            obj = routerItem.meta;
        }

        if (routerItem.children) {
            obj = findAndGetMeta(name, routerItem.children);
        }
    });

    return obj;
};

const applyRoutesMetaToMenu = (menu: Array<any>, routes: Array<RouteRecordRaw>) => {
    return computed(() => {
        const menues: Array<any> = [];
        menu.forEach((menuItem) => {
            if (menuItem.type !== TYPE_ITEM) {
                menues.push(menuItem);
            }

            // if is undefined just return.
            if (typeof menuItem.name !== "undefined") {
                menues.push({...menuItem, ...findAndGetMeta(menuItem.name, routes)});
            }
        });

        return menues;
    });
}

export {
    applyRoutesMetaToMenu
}