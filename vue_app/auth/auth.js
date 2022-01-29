import router from '../router/router.js'
import store from '../store/store.js'
import Vue from 'vue'

export default {
	user: {
		authenticated: false,
	},

	signin: function (user) {
		axios.post('api/login', user).then(response => {
			this.setLocalStorage(response.data)
			this.user.authenticated = true
			axios.defaults.headers.common['Authorization'] = ' Bearer ' + response.data.token
			store.dispatch('getProvincias', this)

			router.push('/')
		}).catch(error => {
			console.log(error);
			//this.$toast.error('Acceso denegado')
		})
	},



	dispatchUser: function (data) {
		store.dispatch('setAuth', true)
		store.dispatch('setUser', data)
	},

	setLocalStorage: function (data) {
		localStorage.setItem('id_token', data.token)
	},

	logout: function () {
		localStorage.removeItem('id_token')
		//store.dispatch('setAuth', false)
		//store.dispatch('setUser', this.setDefault())
		router.push('/login')
	},

	setDefault: function () {
		return {
			name: '...',
		}
	},

	authenticated: function () {
		return this.check()
	},

	check: function () {
		return (localStorage.getItem('id_token') !== null) ? true : false
	}
}
