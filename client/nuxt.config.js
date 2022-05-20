export default {
    // Global page headers: https://go.nuxtjs.dev/config-head
    head: {
        title: 'client',
        htmlAttrs: {
            lang: 'en'
        },
        meta: [
            { charset: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1' },
            { hid: 'description', name: 'description', content: '' },
            { name: 'format-detection', content: 'telephone=no' }
        ],
        link: [
            { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
        ],
        script: [],
    },

    // Global CSS: https://go.nuxtjs.dev/config-css
    css: [
        "~/node_modules/bootstrap/dist/css/bootstrap.min.css",
        '~/assets/css/main.css',
    ],

    // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
    plugins: [
        { src: "~/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js", mode: "client" }
    ],

    // Auto import components: https://go.nuxtjs.dev/config-components
    components: true,

    // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
    buildModules: [],

    // Modules: https://go.nuxtjs.dev/config-modules
    modules: [
        // https://go.nuxtjs.dev/axios
        '@nuxtjs/axios',
        '@nuxtjs/auth-next',
        '@nuxt/http',
        '@nuxtjs/toast',
    ],

    // Axios module configuration: https://go.nuxtjs.dev/config-axios
    axios: {
        // Workaround to avoid enforcing hard-coded localhost:3000: https://github.com/nuxt-community/axios-module/issues/308
        baseURL: 'http://localhost:8000/api',
    },

    // Build Configuration: https://go.nuxtjs.dev/config-build
    build: {},

    // router: {
    //     // middleware: 'authenticated'
    // },

    env: {
        API_URL: "http://127.0.0.1:8000/api",
        IMAGE_URL: "http://127.0.0.1:8000/",
    },

    auth: {
        strategies: {
            'laravelJWT': {
                provider: 'laravel/jwt',
                url: 'http://127.0.0.1:8000/api',
                endpoints: {
                    login: {
                        url: "/auth/login",
                        method: 'post',
                        propertyName: 'data.token'
                    },
                    register: {
                        url: "/auth/register",
                        method: 'post',
                        propertyName: 'data.token'
                    },
                    user: {
                        url: "/auth/me",
                        method: 'get',
                        propertyName: 'data'
                    },
                    logout: {
                        url: "/auth/logout",
                        method: 'delete',
                        propertyName: 'logout'
                    },

                },
                token: {
                    property: 'token',
                    maxAge: 60 * 60
                },
                refreshToken: {
                    maxAge: 20160 * 60
                },
            },
        }
    },

    toast: {
        position: 'bottom-right',
        register: [ // Register custom toasts
            {
                name: 'my-error',
                message: 'Oops...Something went wrong',
                options: {
                    type: 'error'
                }
            }
        ]
    }


}