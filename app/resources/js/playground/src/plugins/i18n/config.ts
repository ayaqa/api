
export const mainMenuTranslations = {
    en: {
        message: {
            home: 'Home',
            configure: 'Configure',
            status: 'Status',
            app: 'App',
            api: 'Api',
            versionInfo: 'Version Info',
            reportABug: 'Report a bug',

            intro: 'Intro',
            support: 'Support',

            github: 'Github',
            twitter: 'Twitter',
            chat: 'Chat',
        }
    }
}

const localesList = [mainMenuTranslations];

export const localesConfigs = {
    en: {
        message: Object.assign({}, ...localesList.map((v) => v.en.message)),
    }
}