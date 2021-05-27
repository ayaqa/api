export interface IConfig {
    IS_PRODUCTION: Boolean,
    PUBLIC_PATH: String,
    API_URL_PATH: String,
    APP_VERSION: String,
    API_VERSION: String,
}

const config: IConfig = {
    IS_PRODUCTION: process.env.NODE_ENV === 'production',
    PUBLIC_PATH: parse(process.env.VUE_PUBLIC_PATH, '/playground/'),
    API_URL_PATH: parse(process.env.VUE_API_URL_PATH, 'http://localhost:8080/api/'),

    APP_VERSION: parse(process.env.VUE_APP_VERSION, '0.0.1'),
    API_VERSION: parse(process.env.VUE_API_VERSION, '0.0.1'),
};

function parse(value: any, fallback: any): any {
    if (typeof value === 'undefined') {
        return fallback;
    }

    switch (typeof fallback) {
        case 'boolean':
            return !!JSON.parse(value);
        case 'number':
            return JSON.parse(value);
        default:
            return value;
    }

}

export default config;
