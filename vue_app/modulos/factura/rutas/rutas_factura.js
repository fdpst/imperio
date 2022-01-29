import Factura from '../componentes/Factura.vue'
import Pos from '../componentes/Pos.vue'
import Formproducto from '../componentes/Formproducto.vue'
import FormEditproducto from '../componentes/FormEditproducto.vue'


const routes = [
   ...route('/generar-factura', Factura, {
      Auth: true
   }),
   ...route('/prueba-factura', Pos, {
      Auth: true
   }),
   // Ruta para editar producto
   ...route('/editar-producto', FormEditproducto, {
   Auth: true
   }),
   // END Ruta para editar producto
   // Ruta para crear producto
   ...route('/crear-producto', Formproducto, {
      Auth: true
      }),
   // END Ruta para crear producto
]

function route(path, component = Default, meta = {}) {
	return [{
		path,
		component,
		meta
	}]
}

export default routes
