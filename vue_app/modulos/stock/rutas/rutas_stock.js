import listaStock from '../componentes/ListaStock.vue'

const routes = [
  ...route('/lista-stock', listaStock, {
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
