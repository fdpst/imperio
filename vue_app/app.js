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
