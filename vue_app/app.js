require('./bootstrap')
window.Vue = require('vue')

import vuetify from './vuetify_installer/vuetify_installer'
import Main from './base_components/main/Main.vue'
import router from './router/router.js'
import auth from './auth/auth.js'
import store from './store/store.js'

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    components:{
      'main-component': Main
    },
    mounted() {
      if (auth.check()) {
          this.$store.dispatch('getProvincias', this)
  	  }
	  },
    methods:{

    }
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

 const files = require.context('./base_components/base', true, /\.vue$/i);
 files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//  cambio a español de textos de dias y meses del calendario
moment.lang('es', {
  months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
  monthsShort: 'Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dec'.split('_'),
  weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
  weekdaysShort: 'Dom_Lun_Mar_Mie_Jue_Vie_Sab'.split('_'),
  weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
})
moment.locale('es')