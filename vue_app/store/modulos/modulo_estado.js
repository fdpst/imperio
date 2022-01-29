const modulo_estado = {
	strict: false,

	state: {
		is_loading: false,
	},

	getters: {
		getloading: state => {
			return state.is_loading
		},
	},

	mutations: {
		is_loading: (state, status) => {
			state.is_loading = status
		},

	},

	actions: {
		isLoading: (context, status) => {
			context.commit('is_loading', status)
		},
	}
}

export default modulo_estado;
