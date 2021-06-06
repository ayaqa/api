<template>
    <q-layout view="hHh LpR lFf">
        <nav-bar />
        <left-side-bar :isOpened="sidebar.leftOpened" />
        <right-side-bar :isOpened="sidebar.rightOpened" />
        <q-page-container>
            <router-view :key="key" v-slot="{ Component }">
                <component :is="Component" />
            </router-view>
        </q-page-container>
        <app-footer />
    </q-layout>
</template>

<script lang="ts">
import { 
    defineComponent,
    computed
} from 'vue'

import { useStore } from 'vuex'
import NavBar from './components/NavBar.vue'
import LeftSideBar from './components/LeftSideBar.vue'
import RightSideBar from './components/RightSideBar.vue';
import AppFooter from './components/Footer.vue'

export default defineComponent({
    name: "DefaultLayout",
    components: {
        NavBar,
        LeftSideBar,
        AppFooter,
        RightSideBar
    },
    setup() {
        const store = useStore();

        const sidebar = computed(() => store.state.app.sidebar);

        return {
            sidebar
        }
    }
});
</script>