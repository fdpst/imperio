const HorasDisponibles = () => import('../componentes/HorasDisponibles.vue')
const Cita = () => import('../componentes/Cita.vue')

const routes = [
  ...route('/horario-disponible', HorasDisponibles, {
     Auth: true
  }),
  ...route('/citas-peluqueria', Cita, {
     Auth: true
  }),
  ...route('/citas-clinica', Cita, {
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
