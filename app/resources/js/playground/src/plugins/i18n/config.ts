import { sideMenu } from "@/router"

export const mainMenuTranslations = {
    en: {
        home: 'Home',
        configure: 'Configure',
        status: 'Status',
        ayaqa: 'AyaQA.com',
        app: 'App',
        api: 'Api',
        versionInfo: 'Version Info',
        reportABug: 'Report a bug',

        support: 'Support',

        github: 'Github',
        twitter: 'Twitter',
        chat: 'Chat',
    },
    bg: {
        home: 'Начало',
        configure: 'Конфигурай',
        status: 'Статус',
    }
}

export const sideMenuTranslations = {
    en: {
        home: 'Home',
        checkboxes: 'Checkboxes',

        simpleHeader: 'Simple'
    },
    bg: {
        home: 'Начало',
        checkboxes: 'Checkboxes',

        simpleHeader: 'Основни'
    }
}

export const commonTranslations = {
    en: {
        logout: 'Logout',
        navigationToggle: 'Show/hide side navigation'
    },
    bg: {
        logout: 'Изход',
        navigationToggle: 'Покажи/скрии страничната навигация'
    }
}

export const localesConfigs = {
    en: {
        menu: mainMenuTranslations.en,
        sidemenu: sideMenuTranslations.en,
        common: commonTranslations.en,
    },
    bg: {
        menu: mainMenuTranslations.bg,
        sidemenu: sideMenuTranslations.bg,
        common: commonTranslations.bg,
    }
}