import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)
import es from 'vuetify/es5/locale/es'

const opts = {
  lang: {
     locales: {es},
     current: 'es',
  },  
}

export default new Vuetify(opts)
