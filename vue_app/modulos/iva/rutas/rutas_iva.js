import FormIva from '../componentes/FormIva.vue'

const routes = [
  ...route('/tipo-iva', FormIva, {
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
