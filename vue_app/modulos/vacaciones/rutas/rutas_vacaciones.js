import Vacaciones from '../componentes/Vacaciones.vue'

const routes = [
  ...route('/vacaciones-empleado', Vacaciones, {
     Auth: true
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
