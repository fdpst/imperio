const modulo_provincias = {
	strict: false,

  state:{
    provincias:[]
  },

	getters: {
		getprovincias: state => state.provincias,
	},

	mutations: {
		get_provincias: (state, provincias) => {
			state.provincias = provincias
		},
	},

	actions: {
		getProvincias: (context, vm) => {
      axios.get('api/getprovincias').then(res => {        
         context.commit('get_provincias', res.data)
      }, res => {

      })
		},
	}
}

export default modulo_provincias;
