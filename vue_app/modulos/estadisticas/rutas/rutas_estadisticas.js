import HomeEstadistica from '../componentes/HomeEstadistica.vue'

import EstadisticaVentas from '../componentes/EstadisticaVentas.vue'
import EstadisticaProductos from '../componentes/EstadisticaProductos.vue'
import EstadisticaServicios from '../componentes/EstadisticaServicios.vue'

const routes = [
  ...route('/estadisticas', HomeEstadistica, {
    Auth:true
  }),
  ...route('/estadistica-ventas', EstadisticaVentas, {
    Auth: true
  }),
  ...route('/estadistica-productos', EstadisticaProductos, {
    Auth: true
  }),
  ...route('/estadistica-servicios', EstadisticaServicios, {
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
