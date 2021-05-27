import { createApp } from 'vue'
import { Quasar } from 'quasar'
import quasarUserOptions from './quasar-user-options'

import App from './App.vue'
import store from "./store";
import router from "./router"

import { i18n } from "@/plugins/i18n";

const app = createApp(App);

app
    .use(Quasar, quasarUserOptions)
    .use(router)
    .use(store)
    .use(i18n)
    .mount("#app");
