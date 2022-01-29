export const menu_items_mixin = {
  data(){
    return {
      items:[
        {
          icon: 'mdi-video',
          text: 'TV',
          user: [1, 2],
          childs:[
            {
              path: '/lista-videos',
              icon: 'mdi-video',
              text: 'Lista videos'
            },
            {
                path: '/lista-usuarios',
                icon: 'mdi-account',
                text: 'Usuarios',
                user: [1]
           },
           {
                path: '/perfil-usuario',
                icon: 'mdi-key',
                text: 'Cuenta',
                user: [1, 2]
           },
          ]
        },

        {
            icon: 'mdi-account-clock',
            text: 'Turnos',
            user: [1, 2],
            childs:[
              {
                   path: '/lista-turnos',
                   icon: 'mdi-account-clock',
                   text: 'Turnos',
                   user: [1, 3]
              },
              {
                  path: '/lista-clientes-tienda',
                  icon: 'mdi-clock-outline',
                  text: 'Prueba tiempos',
                  user: [1]
              },
              {
                  path: '/informe',
                  icon: 'mdi-anchor',
                  text: 'Informes',
                  user: [1]
              },
              {
                  path: '/lista-tiendas',
                  icon: 'mdi-home-city',
                  text: 'Tiendas',
                  user: [1]
             }
          ]
        },

        {
            icon: 'mdi-cellphone-android',
            text: 'App',
            user: [1, 2],
            childs:[
              {
                   path: '/citas-peluqueria?tipo=peluqueria',
                   icon: 'mdi-account',
                   text: 'peluqueria',
                   user: [1, 3]
              },
              {
                   path: '/citas-clinica?tipo=clinica',
                   icon: 'mdi-account',
                   text: 'clinica',
                   user: [1, 3]
              },
              {
                   path: '/lista-empleados-app',
                   icon: 'mdi-account',
                   text: 'empleados app',
                   user: [1, 3]
              },
              {
                   path: '/lista-servicios',
                   icon: 'mdi-file-document-box-outline',
                   text: 'servicios app',
                   user: [1, 3]
              },
              {
                   path: '/lista-usuarios-app',
                   icon: 'mdi-account',
                   text: 'usuarios app',
                   user: [1, 3]
              },
              /*{
                   path: '/lista-mascotas',
                   icon: 'mdi-dog',
                   text: 'mascotas app',
                   user: [1, 3]
              },*/
              {
                   path: '/lista-tiendas-app',
                   icon: 'mdi-account',
                   text: 'tiendas app',
                   user: [1, 3]
              },
              {
                   path: '/horario',
                   icon: 'mdi-account',
                   text: 'Horario tiendas',
                   user: [1, 3]
              },

          ]
        },
      ]

    }
  },

  computed: {
      user() {
          return this.$store.getters.getuser
      },
      computedheaders: function() {
          if (this.user.role != 0) {
              return this.items.filter(x => {
                  return x.user.some(userole => userole == this.user.role)
              })
          }
      }
  }
}
