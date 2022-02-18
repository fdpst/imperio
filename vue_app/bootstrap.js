window._ = require('lodash')
window.Vue = require('vue')
window.moment = require('moment')

moment.updateLocale('en', {
    weekdays : 
	[
        "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"
    ]	
});

import VuetifyToast from 'vuetify-toast-snackbar-ng'

import setup from './interceptors/interceptors.js'
setup()

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Loader from './base_components/base/Loader.vue'
Vue.component('loader', Loader)

import fileComponent from './base_components/base/fileComponent.vue'
Vue.component('file-component', fileComponent)

import Miniloader from './base_components/base/Miniloader.vue'
Vue.component('mini-loader', Miniloader)

import confirmDialog from './base_components/base/confirmDialog.vue'
Vue.component('confirm-dialog', confirmDialog)

window.axios = require('axios')

axios.defaults.headers.common['Content-Type'] = 'application/json'
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
axios.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem('id_token')}`
axios.defaults.withCredentials = true;

Vue.use(VuetifyToast, {
	x: 'right',
	y: 'top',
	color: 'info',
	icon: 'mdi-info',
	timeout: 3000,
	dismissable: true,
	autoHeight: false,
	multiLine: false,
	vertical: false,
	shorts: {
		error: {
			color: 'red'
		},
    	sucs: {
			color: 'green'
		},
		warn: {
			color: 'orange'
		}
	},
	property: '$toast'
})
