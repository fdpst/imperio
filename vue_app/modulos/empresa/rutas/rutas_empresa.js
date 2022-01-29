import ListaEmpresas from '../componentes/ListaEmpresas.vue'
import FormEmpresa from '../componentes/FormEmpresa.vue'

const routes = [
  ...route('/lista-empresas', ListaEmpresas, {
     Auth: true
  }),
  ...route('/guardar-empresa', FormEmpresa, {
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
