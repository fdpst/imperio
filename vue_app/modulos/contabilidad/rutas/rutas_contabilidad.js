import ListaFacturas from '../componentes/ListaFacturas.vue'
import FormFactura from '../componentes/FormFactura.vue'
import HomeContabilidad from '../componentes/HomeContabilidad.vue'
import FormEmitida from '../componentes/FormEmitida.vue'
import ListaEmitidas from '../componentes/ListaEmitidas.vue'
import ListaIngresos from '../componentes/ListaIngresos.vue'
import ListaTickets from '../componentes/ListaTickets.vue'
import FormTicket from '../componentes/FormTicket.vue'

const routes = [
  ...route('/editar-factura', FormFactura, {
     Auth: true
  }),
  ...route('/lista-facturas', ListaFacturas, {
     Auth: true
  }),
  ...route('/lista-tickets', ListaTickets, {
     Auth: true
  }),
  ...route('/contabilidad', HomeContabilidad, {
    Auth:true
  }),
  ...route('/emitir-factura', FormEmitida, {
    Auth: true
  }),
  ...route('/lista-facturas-emitidas', ListaEmitidas, {
    Auth: true
  }),
  ...route('/lista-ingresos', ListaIngresos, {
    Auth: true
  }),
  ...route('/prueba-tickets', FormTicket, {
    Auth: true
  })
]

function route(path, component = Default, meta = {}) {
	return [{
		path,
		component,
		meta
	}]
}

export default routes
