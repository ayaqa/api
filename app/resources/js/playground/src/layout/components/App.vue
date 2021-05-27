<template>
    <q-layout view="hhh LpR fFf">
        <nav-bar />
        <q-drawer show-if-above v-model="sidebar.opened" side="left" bordered>
            <!-- drawer content -->
        </q-drawer>
        <q-page-container>
            <router-view :key="key" v-slot="{ Component }">
                <component :is="Component" />
            </router-view>
        </q-page-container>
    </q-layout>
</template>

<script lang="ts">
import { defineComponent, toRefs, reactive, computed } from "vue"
import { useStore } from 'vuex'
import NavBar from './NavBar.vue'

interface setInterface {
  sidebar: any;
}

export default defineComponent({
    name: "App",
    components: {
        NavBar
    },
    setup() {
        const store = useStore();

        const set: setInterface = reactive({
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
        NavBar