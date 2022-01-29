const ListaTiendasApp = () => import('../componentes/ListaTiendasApp.vue')

const routes = [
  ...route('/lista-tiendas-app', ListaTiendasApp, {
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
