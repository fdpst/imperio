import VueRouter from 'vue-router'
import auth from '../auth/auth.js'

import Inicio from '../base_components/inicio/Inicio.vue'
import Login from '../base_components/login/Login.vue'

/*importar rutas */
import rutas_empleados from '../modulos/empleados/rutas/rutas_empleados'
import rutas_servicios from '../modulos/servicios/rutas/rutas_servicios'
import rutas_clientes from '../modulos/clientes/rutas/rutas_clientes'
import rutas_stock from '../modulos/stock/rutas/rutas_stock'
import rutas_empresa from '../modulos/empresa/rutas/rutas_empresa'
import rutas_recibo from '../modulos/recibo/rutas/rutas_recibo'
import rutas_contabilidad from '../modulos/contabilidad/rutas/rutas_contabilidad'
import rutas_vacaciones from '../modulos/vacaciones/rutas/rutas_vacaciones'
import rutas_informacion from '../modulos/informacion/rutas/rutas_informacion'
import rutas_factura from '../modulos/factura/rutas/rutas_factura';
import rutas_categoria from '../modulos/categoria/rutas/rutas_categoria';
import rutas_iva from '../modulos/iva/rutas/rutas_iva'
import rutas_presupuesto from '../modulos/presupuesto/rutas/rutas_presupuesto'
import rutas_tiendas_app from '../modulos/tiendas_app/rutas/rutas_tiendas_app'
import app_rutas_empleado from '../modulos/app_empleados/rutas/app_rutas_empleados'
import rutas_citas from '../modulos/citas/rutas/rutas_citas'
import rutas_estadisticas from '../modulos/estadisticas/rutas/rutas_estadisticas'
import rutas_pedir_cita from '../modulos/pedir_cita/rutas/rutas_pedir_cita'


/* importar rutas */

const base_routes = [
	 ...route('/login', Login),
	 ...route('/', Inicio, {
 		  Auth: true
 	 }),
	 ...rutas_empleados,
	 ...app_rutas_empleado,
	 ...rutas_clientes,
	 ...rutas_servicios,
	 ...rutas_stock,
	 ...rutas_empresa,
	 ...rutas_recibo,
	 ...rutas_contabilidad,
	 ...rutas_vacaciones,
	 ...rutas_informacion,
	 ...rutas_factura,
	 ...rutas_categoria,
	 ...rutas_iva,
	 ...rutas_presupuesto,
	 ...rutas_tiendas_app,
	 ...rutas_citas,
	 ...rutas_estadisticas,
	 ...rutas_pedir_cita

 ]

const routes = [
		...base_routes
]

const router = new VueRouter({
	routes
})

function route(path, component = Default, meta = {}) {
	return [{
		path,
		component,
		meta
	}]
}

router.beforeEach((to, from, next) => {
	if (to.meta.Auth) {
		if (!auth.authenticated()) {
			next({
				path: '/login',
				query: {
					redirect: to.fullPath
				}
			})
		} else {
			next()
		}
	} else {
		next()
	}
})

export default router
