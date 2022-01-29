const AppFormEmpleados = () => import('../componentes/AppFormEmpleados.vue')
const AppListaEmpleados = () => import('../componentes/AppListaEmpleados.vue')

const routes = [
  ...route('/guardar-empleado-app', AppFormEmpleados, {
     Auth: true
  }),
  ...route('/lista-empleados-app', AppListaEmpleados, {
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
