import FormEmpleados from '../componentes/FormEmpleados.vue'
import ListaEmpleados from '../componentes/ListaEmpleados'

const routes = [
  ...route('/guardar-empleado', FormEmpleados, {
     Auth: true
  }),
  ...route('/lista-empleados', ListaEmpleados, {
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
