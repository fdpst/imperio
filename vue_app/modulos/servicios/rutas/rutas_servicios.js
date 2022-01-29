import FormServicio from '../componentes/formServicio.vue'
import FormEditServicio from '../componentes/formEditServicio.vue'
import ListaServicios from '../componentes/ListaServicios.vue'

const routes = [
	// Ruta para editar servicio
	...route('/editar-servicio', FormEditServicio, {
	Auth: true
	}),
	// END Ruta para editar servicio
	// Ruta para crear servicio
	...route('/crear-servicio', FormServicio, {
		Auth: true
		}),
	// END Ruta para crear servicio
  ...route('/lista-servicios', ListaServicios, {
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