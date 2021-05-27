module.exports = {
  publicPath: process.env.NODE_ENV === 'production'
      ? '/playground/'
      : '/',
  pluginOptions: {
    quasar: {
      importStrategy: 'kebab',
      rtlSupport: false
    }
  },
  transpileDependencies: [
    'quasar'
  ]
}
