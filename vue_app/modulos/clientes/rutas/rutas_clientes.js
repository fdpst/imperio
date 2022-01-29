import FormCliente from '../componentes/FormCliente.vue'
import ListaClientes from '../componentes/ListaClientes'

const routes = [
  ...route('/guardar-cliente', FormCliente, {
     Auth: true
  }),
  ...route('/lista-clientes', ListaClientes, {
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
