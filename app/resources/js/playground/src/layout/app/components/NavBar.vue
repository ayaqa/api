<template>
        <q-header reveal class="bg-primary text-white">
            <q-toolbar>
                <q-btn dense flat round :icon="mdiMenu" @click="toggleLeftDrawer" :data-ayaqa="dataAttribute(attrs.toggleSideMenu)">
                    <q-tooltip>
                        {{ t('common.navigationToggle') }}
                    </q-tooltip>
                </q-btn>
                <q-toolbar-title shrink>
                    <q-avatar>
                        <img src="https://cdn.quasar.dev/logo/svg/quasar-logo.svg">
                    </q-avatar>
                    AyaQA Playground
                </q-toolbar-title>
                <q-tabs v-model="activeMenuItem" inline-label :data-ayaqa="dataAttribute(attrs.topMenu)">
                    <template v-for="(item, index) in navBarMenu" :key="index">
                        <q-route-tab :icon="item.icon" :name="item.name" :label="t(item.title)" :data-ayaqa="dataAttribute(item.ayaqa)" :to="item.name" />
                    </template>
                </q-tabs>
                <q-space />
                <q-btn-dropdown stretch flat :label="t('menu.support')" :data-ayaqa="dataAttribute(attrs.menuSupport)">
                    <q-list dense padding>
                        <template v-for="(item, idx) in supportDropDownItems" :key="idx">
                        <q-item clickable v-close-popup @click="onClickItem(item.url)" v-if="item !== '-'">
                            <q-item-section avatar>
                                <q-icon :name="item.icon" size="sm" />
                            </q-item-section>
                            <q-item-section>
                                {{ t(item.text) }}
                            </q-item-section>
                        </q-item>
                        <q-separator v-if="item === '-'" />
                        </template>
                    </q-list>
                </q-btn-dropdown>
                <q-btn flat round :icon="mdiLogout" :data-ayaqa="dataAttribute(attrs.menuLogoutBtn)">
                    <q-tooltip>
                        {{ t('common.logout') }}
                    </q-tooltip>
                </q-btn>
            </q-toolbar>
        </q-header>
</template>
<script lang="ts">
import { defineComponent, ref, watch } from "vue";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { 
    mdiGithub,
    mdiMenu,
    mdiWeb,
    mdiTwitter,
    mdiChat,
    mdiFileDocument,
    mdiInformation,

    mdiFlask,
    mdiFileDocumentOutline,
    mdiLogout
} from '@quasar/extras/mdi-v5';

import { useRouter, useRoute, RouteRecordName } from "vue-router";

import config from '@/config';
import { urls, attrs } from '@/constants'
import dataAttribute from '@/utils/data-аttribute'

import { 
    topMenu 
} from '@/router'

import { applyRoutesMetaToMenu } from '@/utils/routesHelper'

export default defineComponent({
    name: "NavBar",
    setup() {
        const store = useStore();
        const { t } = useI18n();
        const route = useRoute();
        const { options } = useRouter();

        let activeMenuItem = ref('');
        watch(() => route.name, (newName: RouteRecordName): void => {
            activeMenuItem.value = newName.toString();
        });

        const supportDropDownItems = [
            { icon: mdiFileDocument, url: `${urls.AYAQA_VERSION_INFO}/${config.APP_VERSION}`, text: 'menu.versionInfo' },
            { icon: mdiGithub, url: `${urls.AYAQA_GITHUB_REPORT_BUT}`, text: 'menu.reportABug' },
            '-',
            { icon: mdiWeb, url: urls.AYAQA_SITE, text: 'menu.ayaqa' },
            { icon: mdiGithub, url: urls.AYAQA_GITHUB, text: 'menu.github' },
            '-',
            { icon: mdiTwitter, url: urls.AYAQA_TWITTER, text: 'menu.twitter' },
            { icon: mdiChat, url: urls.AYAQA_CHAT, text: 'menu.chat' },
        ];

        const navBarMenu = applyRoutesMetaToMenu(topMenu, options.routes);

        const toggleLeftDrawer = () => {
            store.dispatch("app/toggleSideBar");
        };

        const onClickItem = (url: string) => {
            window.open(url, '_blank');
        }

        return {
            mdiMenu,
            mdiInformation,
            mdiFlask,
            mdiFileDocumentOutline,
            mdiLogout,

            navBarMenu,
            supportDropDownItems,

            toggleLeftDrawer,
            onClickItem,
            t,

            attrs,
            dataAttribute,
            activeMenuItem
        }
    }
})
</script>