export default {
  // Global page headers (https://go.nuxtjs.dev/config-head)
  head: {
    htmlAttrs: {
      lang: 'ru',
    },
    title: 'nuxt.loc',
    meta: [
      {charset: 'utf-8'},
      {name: 'viewport', content: 'width=device-width, initial-scale=1'},
      {hid: 'description', name: 'description', content: ''},
      {hid: 'keywords', name: 'keywords', content: ''},
    ],
    link: [
      {rel: 'icon', type: 'image/png', href: '/favicon.png'},
    ],
    script: [
      {
        src: '/js/materialize.min.js',
      },
    ],
  },

  pwa: {
    meta: {
      lang: 'ru',
      favicon: false,
      icon: false,
    },
  },

  // Global CSS (https://go.nuxtjs.dev/config-css)
  css: [
    '@/assets/fonts/icon.css',
    '@/assets/scss/materialize.min.scss',
    '@/assets/scss/index.scss',
  ],

  // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
  plugins: [
    {src: '~/plugins/data.filter'},
    {src: '~/plugins/tooltip'},
    {src: '~/plugins/Vuelidate'},
    {src: '~/plugins/toasts', mode: 'client'},
  ],

  // Auto import components (https://go.nuxtjs.dev/config-components)
  components: true,

  // Modules for dev and build (recommended)
  // (https://go.nuxtjs.dev/config-modules)
  buildModules: [],

  // Modules (https://go.nuxtjs.dev/config-modules)
  modules: [
    // https://go.nuxtjs.dev/pwa
    '@nuxtjs/pwa',
    // axios
    '@nuxtjs/axios',
    // markdownit
    '@nuxtjs/markdownit',
    'cookie-universal-nuxt',
  ],

  axios: {
    baseURL: 'http://server.loc',
  },

  markdownit: {
    preset: 'default',
    linkify: true,
    breaks: true,
    typographer: true,
    injected: true,
    html: true,
  },

  env: {
    appName: 'SSR блог',
  },

  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {},
};
