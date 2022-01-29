import ListaCategoria from '../componentes/ListaCategoria.vue'

const routes = [
  ...route('/lista-categoria', ListaCategoria, {
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
