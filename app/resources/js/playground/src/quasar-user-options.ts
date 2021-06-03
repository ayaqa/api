import './styles/quasar.sass'
import mdiIconSet from 'quasar/icon-set/svg-mdi-v5'

// To be used on app.use(Quasar, { ... })
export default {
  iconSet: mdiIconSet,
  config: {
    brand: {
      primary: 'rgb(0,150,136)',
      secondary: '#26A69A',
      accent: '#9C27B0',

      dark: '#1d1d1d',

      positive: '#21BA45',
      negative: '#C10015',
      info: '#31CCEC',
      warning: '#F2C037'
    }
  },
  plugins: {
  }
}
