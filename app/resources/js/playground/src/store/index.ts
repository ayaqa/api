import { createStore, createLogger } from 'vuex'
import app from './modules/app'
import getters from './getters'

export default createStore({
    getters,
    plugins: [
      createLogger()
    ],
    modules: {
      app,
    }
  })