<template>
    <q-layout view="hHh lpR lFf" key="layout">
        <nav-bar />
        <q-drawer 
            v-model="sidebar.opened" 
            side="left"
            width="200"
            breakpoint="400"
            show-if-above
            bordered
        >
            <side-menu />
        </q-drawer>
        <q-page-container>
            <router-view :key="key" v-slot="{ Component }">
                <component :is="Component" />
            </router-view>
        </q-page-container>
        <q-footer reveal class="bg-teal-1 text-primary">
            <q-space />
            App version: 12345 &nbsp;
            API version: 12345
        </q-footer>
    </q-layout>
</template>

<script lang="ts">
import { 
    defineComponent,
    toRefs,
    reactive,
    computed
} from 'vue'

import { useStore } from 'vuex'
import NavBar from './components/NavBar.vue'
import SideMenu from './components/SideMenu.vue'

interface ISet {
  sidebar: Boolean;
}

export default defineComponent({
    name: "DefaultLayout",
    components: {
        NavBar,
        SideMenu
    },
    setup() {
        const store = useStore();

        const set: ISet = reactive({
            sidebar: computed(() => {
                return store.state.app.sidebar;
            }),   
        });

        return {
            ...toRefs(set)
        }
    }
});
</script>