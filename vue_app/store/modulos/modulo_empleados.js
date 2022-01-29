const modulo_empleados = {
	strict: false,

  state:{
    empleados:[]
  },

	getters: {
		getempleados: state => state.empleados,
	},

	mutations: {
		save_empleado: (state, empleado) => {
			state.empleados.push(empleado)
		},
	},

	actions: {
		saveEmpleado: (context, empleado) => {
			context.commit('save_empleado', empleado)
		},
	}
}

export default modulo_empleados;
