import { App } from "vue";
import { createI18n } from "vue-i18n";
import { localesConfigs } from "./config";

console.log(localesConfigs);

export const i18n = createI18n({
    locale: "en",
    fallbackLocale: "en",
    messages: localesConfigs,
});