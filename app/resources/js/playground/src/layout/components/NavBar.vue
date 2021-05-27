<template>
        <q-header reveal class="bg-primary text-white">
            <q-toolbar>
                <q-btn dense flat round :icon="mdiMenu" @click="toggleLeftDrawer" data-ayaqa="toggle-left-menu" />
                <q-toolbar-title shrink>
                    <q-avatar>
                        <img src="https://cdn.quasar.dev/logo/svg/quasar-logo.svg">
                    </q-avatar>
                    AyaQA Playground
                </q-toolbar-title>
                <q-separator dark vertical inset spaced />
                <q-tabs v-model="tab" shrink data-ayaqa="top-menu">
                    <q-tab name="home" :label="t('message.home')" data-ayaqa="top-menu-item-home" />
                    <q-tab name="configure" :label="t('message.configure')" data-ayaqa="top-menu-item-configure" />
                    <q-tab name="status" :label="t('message.status')" data-ayaqa="top-menu-item-status" />
                </q-tabs>
                <q-space />
                <q-btn-dropdown stretch flat :label="appVersion" data-ayaqa="top-menu-item-version">
                    <q-list dense padding>
                        <q-item>
                            <q-item-section avatar>
                                <q-icon :name="mdiInformation" size="sm" />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label caption>{{ t('message.app') }}: <strong>{{ appVersion }}</strong></q-item-label>
                                <q-item-label caption>{{ t('message.api') }}: &nbsp;<strong>{{ apiVersion }}</strong></q-item-label>
                            </q-item-section>
                        </q-item>
                        <q-separator />
                        <template v-for="(item, idx) in versionMenu" :key="idx">
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
                <q-btn stretch flat :label="t('message.intro')" data-ayaqa="top-menu-item-intro" />
                <q-btn-dropdown stretch flat :label="t('message.support')" data-ayaqa="top-menu-item-support">
                    <q-list dense padding>
                        <template v-for="(item, idx) in supportConfig" :key="idx">
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
            </q-toolbar>
        </q-header>
</template>
<script lang="ts">
import { defineComponent, ref } from "vue";
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
} from '@quasar/extras/mdi-v5';

import config from '@/config';
import constants from '@/constants'

export default defineComponent({
    setup() {
        const tab = ref('home');
        const store = useStore();

        const { t } = useI18n();

        const supportConfig = [
            { icon: mdiWeb, url: constants.urls.AYAQA_SITE, text: 'AyaQA.com' },
            { icon: mdiGithub, url: constants.urls.AYAQA_GITHUB, text: 'message.github' },
            '-',
            { icon: mdiTwitter, url: constants.urls.AYAQA_TWITTER, text: 'message.twitter' },
            { icon: mdiChat, url: constants.urls.AYAQA_CHAT, text: 'message.chat' },
        ];

        const versionMenu = [
            { icon: mdiFileDocument, url: `${constants.urls.AYAQA_VERSION_INFO}/${config.APP_VERSION}`, text: 'message.versionInfo' },
            { icon: mdiGithub, url: `${constants.urls.AYAQA_GITHUB_REPORT_BUT}`, text: 'message.reportABug' },
        ];

        const toggleLeftDrawer = () => {
            store.dispatch("app/toggleSideBar");
        };

        const onClickItem = (url: string) => {
            window.open(url, '_blank');
        }

        return {
            mdiMenu,
            mdiInformation,

            supportConfig,
            versionMenu,

            appVersion: config.APP_VERSION,
            apiVersion: config.API_VERSION,

            tab,
            toggleLeftDrawer,
            onClickItem,
            t,
        }
    }
})
</script>
<style scoped lang="scss">
.app-version {
    margin-right: 25px;
    color: #333;
}
</style>