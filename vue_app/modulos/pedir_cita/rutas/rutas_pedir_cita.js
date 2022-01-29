import FormCita from '../componentes/FormCita.vue'

const routes = [
  ...route('/pedir-cita', FormCita, {
     Auth: false
  }),
]

function route(path, component = Default, meta = {}) {
	return [{
		path,
		component,
		meta
	}]
}

export default routes
