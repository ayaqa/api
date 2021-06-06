<template>
   <q-drawer 
        v-model="isOpen" 
        side="left"
        width=200
        show-if-above
        bordered
    >
        <q-scroll-area class="fit">
            <q-list data-ayaqa="side-menu">
                <template v-for="(item, idx) in menuItems">
                    <q-item-label 
                        v-if="item.type === TYPE_HEADER" 
                        :key="idx"
                        data-ayaqa="side-menu-header"
                        header
                    >
                        {{ t(item.title) }}
                    </q-item-label>
                    <q-item
                        clickable
                        v-ripple
                        :to="item.name"
                        :active="item.name === activeRouterName"
                        v-if="item.type === TYPE_ITEM"
                        :key="idx"
                        :data-ayaqa="item.ayaqa"
                    >
                        <q-item-section avatar>
                            <q-icon :name="item.icon" />
                        </q-item-section>
                        <q-item-section>
                            {{ t(item.title) }}
                        </q-item-section>
                    </q-item>
                    <q-separator v-if="item.type === TYPE_SEPARATOR" :key="idx" />
                </template>
            </q-list>
        </q-scroll-area>
   </q-drawer>
</template>

<script lang="ts">
import { 
    defineComponent,
    computed,
    toRef
} from 'vue'

import { useRouter, useRoute } from "vue-router";
import { useI18n } from "vue-i18n";

import { 
    TYPE_ITEM, 
    TYPE_SEPARATOR, 
    TYPE_HEADER, 
    sideMenu 
} from '@/router'

import { applyRoutesMetaToMenu } from '@/utils/routesHelper'

export default defineComponent({
    name: "LeftSideBar",
    props: {
        isOpened: Boolean,
    },
    setup(props) {
        const { options } = useRouter();
        const { t } = useI18n();
        const { name } = useRoute();


        let isOpen = toRef(props, 'isOpened');

        const activeRouterName = computed(() => {
            return name;
        });

        const menuItems = applyRoutesMetaToMenu(sideMenu, options.routes);

        return {
            isOpen,

            t,
            activeRouterName, 
            menuItems,

            TYPE_ITEM,
            TYPE_SEPARATOR,
            TYPE_HEADER,
        }
    }
});
</script>