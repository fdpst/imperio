import modulo_empleados from './modulos/modulo_empleados'
import modulo_estado from './modulos/modulo_estado'
import modulo_provincias from './modulos/modulo_provincias'
import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex)

const store = new Vuex.Store({
	strict: false,
	modules: {
		empleados: modulo_empleados,
		estado: modulo_estado,
		provincias: modulo_provincias
	},
})

export default store;
