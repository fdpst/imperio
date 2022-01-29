import FormInformacion from '../componentes/FormInformacion.vue'

const routes = [
  ...route('/informacion-legal', FormInformacion, {
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
