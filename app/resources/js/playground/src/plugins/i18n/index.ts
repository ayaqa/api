import { createI18n } from "vue-i18n";
import { localesConfigs } from "./config";

export const i18n = createI18n({
    locale: "en",
    fallbackLocale: "en",
    messages: localesConfigs,
});