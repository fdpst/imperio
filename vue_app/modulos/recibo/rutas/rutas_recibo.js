import FormRecibo from '../componentes/FormRecibo.vue'
import ListaRecibos from '../componentes/ListaRecibos.vue'

const routes = [
  ...route('/guardar-albaran', FormRecibo, {
     Auth: true
  }),
  ...route('/lista-albaranes', ListaRecibos, {
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
