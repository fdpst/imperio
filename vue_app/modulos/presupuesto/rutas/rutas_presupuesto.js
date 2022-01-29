import ListaPresupuestos from '../componentes/ListaPresupuestos.vue'

const routes = [
  ...route('/lista-presupuestos', ListaPresupuestos, {
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
