(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _horarioComponent__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./horarioComponent */ "./vue_app/modulos/app_empleados/componentes/horarioComponent.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    horarioComponent: _horarioComponent__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      tiendas: [],
      contador: 1,
      mask: '##:##',
      dias: [{
        dia: 1,
        text: 'Lunes'
      }, {
        dia: 2,
        text: 'Martes'
      }, {
        dia: 3,
        text: 'Miercoles'
      }, {
        dia: 4,
        text: 'Jueves'
      }, {
        dia: 5,
        text: 'Viernes'
      }, {
        dia: 6,
        text: 'Sabado'
      }, {
        dia: 0,
        text: 'Domingo'
      }],
      headers: [{
        text: 'Tienda',
        align: 'left',
        value: 'nombre_tienda'
      }, {
        text: 'Dia',
        align: 'left',
        value: 'dia'
      }, {
        text: 'Entrada',
        value: 'entrada'
      }, {
        text: 'Salida',
        value: 'salida'
      }, {
        text: 'Acciones',
        value: 'action',
        sortable: false
      }],
      tipos: [],
      dialog: false,
      tipo_libre: 'L',
      color: {
        hex: '#000'
      },
      empleado: {
        id: '',
        nombre: '',
        email: '',
        telefono: '',
        is_active: true,
        color: '#000',
        tipo_id: 1,
        lista_libres: [],
        lista_vacaciones: [],
        horario: [],
        tienda: [],
        tipo_libre: 'L'
      },
      horario: {
        id: "temp-".concat(new Date().getTime()),
        dia: null,
        app_tienda_id: null,
        entrada: '00:00',
        salida: '00:00',
        entrada2: '00:00',
        salida2: '00:00'
      }
    };
  },
  watch: {
    'color.hex': function colorHex(n) {
      this.empleado.color = n;
    }
  },
  created: function created() {
    this.getTipos();
    this.getTiendas();

    if (this.$route.query.id) {
      this.getEmpleado(this.$route.query.id);
    }
  },
  methods: {
    getTipos: function getTipos() {
      var _this = this;

      axios.get("api/app/gettipos").then(function (res) {
        _this.tipos = res.data;
      }, function (res) {
        _this.$toast.error('Algo ha salido mal');
      });
    },
    getTiendas: function getTiendas() {
      var _this2 = this;

      axios.get("api/app/gettiendas").then(function (res) {
        _this2.tiendas = res.data;
      }, function (res) {
        _this2.$toast.error('Algo ha salido mal');
      });
    },
    getEmpleado: function getEmpleado(empleado_id) {
      var _this3 = this;

      axios.get("api/app/getempleado/".concat(empleado_id)).then(function (res) {
        _this3.empleado = res.data.empleado;
        _this3.empleado.tipo_libre = 'L';
      }, function (res) {
        _this3.$toast.error('Algo ha salido mal');
      });
    },
    saveEmpleado: function saveEmpleado() {
      var _this4 = this;

      var tiendas_empleado = [];
      this.tiendas.forEach(function (element) {
        tiendas_empleado.push(element.id);
      });
      this.empleado.tienda = tiendas_empleado;
      axios.post('api/app/saveempleado', this.empleado).then(function (res) {
        _this4.$router.push('lista-empleados-app');
      }, function (res) {
        _this4.$toast.error('Algo ha salido mal');
      });
    },
    deleteEmpleado: function deleteEmpleado() {
      var _this5 = this;

      axios.get("api/app/deleteempleado/".concat(this.empleado.id)).then(function (res) {
        _this5.dialog = false;

        _this5.$router.push('lista-empleados-app');
      }, function (res) {
        _this5.$toast.error('Algo ha salido mal');
      });
    },
    pushHorario: function pushHorario() {
      var _this6 = this;

      axios.post("api/app/savehorario/".concat(this.empleado.id), this.horario).then(function (res) {
        var horario_guardado = res.data.horario;

        if (res.data.was_created) {
          _this6.empleado.horario.push(horario_guardado); // Actualizamos el segundo horario


          if (res.data.was_created2) {
            var horario_guardado2 = res.data.horario2;

            _this6.empleado.horario.push(horario_guardado2);
          }

          _this6.resetForm();

          return null;
        }

        var i = _this6.empleado.horario.findIndex(function (horario) {
          return horario.id == horario_guardado.id;
        });

        _this6.$set(_this6.empleado.horario, i, horario_guardado);

        _this6.resetForm();
      }, function (res) {
        _this6.$toast.error('Algo ha salido mal');
      });
    },
    resetForm: function resetForm() {
      this.horario = {
        id: "temp-".concat(new Date().getTime()),
        dia: null,
        app_tienda_id: null,
        entrada: '00:00',
        salida: '00:00',
        entrada2: '00:00',
        salida2: '00:00'
      };
    },
    setHorario: function setHorario(item) {
      this.horario = item;
      this.horario.entrada2 = "00:00";
      this.horario.salida2 = "00:00";
    },
    deleteHorario: function deleteHorario(item) {
      var _this7 = this;

      axios.post("api/app/deletehorario/".concat(item.id)).then(function (res) {
        var i = _this7.empleado.horario.findIndex(function (x) {
          return x.id == item.id;
        });

        _this7.empleado.horario.splice(i, 1);
      }, function (res) {
        _this7.$toast.error('Algo ha salido mal');
      });
    }
  },
  filters: {
    getday: function getday(val) {
      switch (val) {
        case 0:
          return 'Domingo';
          break;

        case 1:
          return 'Lunes';
          break;

        case 2:
          return 'Martes';
          break;

        case 3:
          return 'Miercoles';
          break;

        case 4:
          return 'Jueves';
          break;

        case 5:
          return 'Viernes';
          break;

        case 6:
          return 'Sabado';
          break;

        default:
          return 'N/A';
      }
    }
  },
  computed: {
    isloading: function isloading() {
      return this.$store.getters.getloading;
    },
    filter_days: function filter_days() {
      var _this8 = this;

      return this.empleado.horario.filter(function (element) {
        return element.app_tienda_id == _this8.horario.app_tienda_id;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['empleado_id', 'fechas', 'tiendas'],
  data: function data() {
    return {
      local_fechas: [],
      allowed_minutes: [0, 15, 30, 45],
      menu: false,
      menu2: false,
      menu3: false,
      horario: {
        id: null,
        app_tienda_id: null,
        fechas: [],
        entrada: "00:00",
        salida: "00:00",
        entrada2: '00:00',
        salida2: '00:00'
      },
      headers: [{
        text: 'Tienda',
        align: 'left',
        value: 'app_tienda_id',
        sortable: false
      }, {
        text: 'Fecha',
        align: 'left',
        value: 'fecha',
        sortable: false
      }, {
        text: 'Entrada',
        value: 'entrada',
        sortable: false
      }, {
        text: 'Salida',
        value: 'salida',
        sortable: false
      }, {
        text: 'Acciones',
        value: 'action',
        sortable: false
      }]
    };
  },
  watch: {
    'fechas': {
      immediate: true,
      handler: function handler(n) {
        this.local_fechas = JSON.parse(JSON.stringify(n));
      }
    }
  },
  methods: {
    guardarHorario: function guardarHorario() {
      var _this = this;

      axios.post("api/app/add-horario/".concat(this.empleado_id), this.horario).then(function (res) {
        _this.local_fechas = res.data;

        _this.$toast.sucs('Fecha guardada');

        _this.resetForm();
      }, function (res) {
        _this.$toast.error('Algo ha salido mal');
      });
    },
    deleteHorario: function deleteHorario(item) {
      var _this2 = this;

      axios.get("api/app/delete-horario/".concat(item.id)).then(function (res) {
        var i = _this2.local_fechas.findIndex(function (x) {
          return x.id == item.id;
        });

        _this2.local_fechas.splice(i, 1);

        _this2.$toast.sucs('Fecha Eliminada');
      }, function (res) {
        _this2.$toast.error('Algo ha salido mal');
      });
    },
    setHorario: function setHorario(item) {
      this.horario = item;
      this.horario.fechas = [item.fecha];
      this.horario.entrada2 = "00:00";
      this.horario.salida2 = "00:00";
    },
    resetForm: function resetForm() {
      this.horario = {
        id: null,
        app_tienda_id: null,
        fechas: [],
        entrada: "00:00",
        salida: "00:00",
        entrada2: '00:00',
        salida2: '00:00'
      };
    }
  },
  filters: {
    gettienda: function gettienda(val, tiendas) {
      var nombre = "";
      tiendas.forEach(function (element) {
        if (element.id == val) {
          nombre = element.nombre;
        }
      });
      return nombre;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=template&id=4c693b1a&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=template&id=4c693b1a& ***!
  \*************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-container",
    [
      _c("v-custom-title", { attrs: { text: "Guardar / Editar Empleado" } }),
      _vm._v(" "),
      _vm.isloading ? _c("loader") : _vm._e(),
      _vm._v(" "),
      _c(
        "v-row",
        [
          _c(
            "v-col",
            { attrs: { cols: "12", md: "4" } },
            [
              _c(
                "v-form",
                [
                  _c(
                    "v-row",
                    { attrs: { dense: "" } },
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12" } },
                        [
                          _c("v-text-field", {
                            attrs: {
                              filled: "",
                              label: "Nombre",
                              required: ""
                            },
                            model: {
                              value: _vm.empleado.nombre,
                              callback: function($$v) {
                                _vm.$set(_vm.empleado, "nombre", $$v)
                              },
                              expression: "empleado.nombre"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-row",
                    { attrs: { dense: "" } },
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12" } },
                        [
                          _c("v-text-field", {
                            attrs: { filled: "", label: "Email", required: "" },
                            model: {
                              value: _vm.empleado.email,
                              callback: function($$v) {
                                _vm.$set(_vm.empleado, "email", $$v)
                              },
                              expression: "empleado.email"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-row",
                    { attrs: { dense: "" } },
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12" } },
                        [
                          _c("v-text-field", {
                            attrs: {
                              filled: "",
                              label: "teléfono",
                              required: ""
                            },
                            model: {
                              value: _vm.empleado.telefono,
                              callback: function($$v) {
                                _vm.$set(_vm.empleado, "telefono", $$v)
                              },
                              expression: "empleado.telefono"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-row",
                    { attrs: { dense: "" } },
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12" } },
                        [
                          _c("v-color-picker", {
                            attrs: { mode: "hexa" },
                            model: {
                              value: _vm.empleado.color,
                              callback: function($$v) {
                                _vm.$set(_vm.empleado, "color", $$v)
                              },
                              expression: "empleado.color"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-row",
                    { attrs: { dense: "" } },
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12" } },
                        [
                          _c(
                            "v-btn",
                            {
                              staticClass: "white--text",
                              attrs: {
                                rounded: "",
                                depressed: "",
                                disabled: _vm.isloading,
                                color: "success"
                              },
                              on: { click: _vm.saveEmpleado }
                            },
                            [_vm._v("Guardar")]
                          ),
                          _vm._v(" "),
                          _vm.empleado.id
                            ? _c(
                                "v-btn",
                                {
                                  staticClass: "white--text",
                                  attrs: {
                                    rounded: "",
                                    depressed: "",
                                    disabled: _vm.isloading,
                                    color: "red"
                                  },
                                  on: {
                                    click: function($event) {
                                      _vm.dialog = true
                                    }
                                  }
                                },
                                [_vm._v("Eliminar")]
                              )
                            : _vm._e()
                        ],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("v-col", { attrs: { cols: "12", md: "1" } }),
          _vm._v(" "),
          _c(
            "v-col",
            { attrs: { cols: "12", md: "6" } },
            [
              _c("h3", [_vm._v("Días libres")]),
              _vm._v(" "),
              _c("v-date-picker", {
                attrs: {
                  color: "green",
                  "first-day-of-week": "1",
                  multiple: ""
                },
                model: {
                  value: _vm.empleado.lista_libres,
                  callback: function($$v) {
                    _vm.$set(_vm.empleado, "lista_libres", $$v)
                  },
                  expression: "empleado.lista_libres"
                }
              })
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("h3", { staticClass: "mt-5" }, [_vm._v("Horario Habitual")]),
      _vm._v(" "),
      _vm.empleado.id != null
        ? _c(
            "v-row",
            [
              _c(
                "v-col",
                { attrs: { cols: "12", md: "10" } },
                [
                  _c(
                    "v-row",
                    { attrs: { dense: "", align: "center" } },
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "2" } },
                        [
                          _c("v-select", {
                            attrs: {
                              label: "Tiendas",
                              items: _vm.tiendas,
                              "item-text": "nombre",
                              "item-value": "id"
                            },
                            model: {
                              value: _vm.horario.app_tienda_id,
                              callback: function($$v) {
                                _vm.$set(_vm.horario, "app_tienda_id", $$v)
                              },
                              expression: "horario.app_tienda_id"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "2" } },
                        [
                          _c("v-select", {
                            attrs: {
                              label: "Dia",
                              items: _vm.dias,
                              "item-text": "text",
                              "prepend-icon": "mdi-calendar",
                              "item-value": "dia"
                            },
                            model: {
                              value: _vm.horario.dia,
                              callback: function($$v) {
                                _vm.$set(_vm.horario, "dia", $$v)
                              },
                              expression: "horario.dia"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "1" } },
                        [
                          _c("v-text-field", {
                            directives: [
                              {
                                name: "mask",
                                rawName: "v-mask",
                                value: "##:##",
                                expression: "'##:##'"
                              }
                            ],
                            attrs: { label: "Entrada", required: "" },
                            model: {
                              value: _vm.horario.entrada,
                              callback: function($$v) {
                                _vm.$set(_vm.horario, "entrada", $$v)
                              },
                              expression: "horario.entrada"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "1" } },
                        [
                          _c("v-text-field", {
                            directives: [
                              {
                                name: "mask",
                                rawName: "v-mask",
                                value: "##:##",
                                expression: "'##:##'"
                              }
                            ],
                            attrs: { label: "Salida", required: "" },
                            model: {
                              value: _vm.horario.salida,
                              callback: function($$v) {
                                _vm.$set(_vm.horario, "salida", $$v)
                              },
                              expression: "horario.salida"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "1" } },
                        [
                          _c("v-text-field", {
                            directives: [
                              {
                                name: "mask",
                                rawName: "v-mask",
                                value: "##:##",
                                expression: "'##:##'"
                              }
                            ],
                            attrs: {
                              disabled:
                                _vm.horario.entrada == "00:00" ||
                                _vm.horario.salida == "00:00",
                              label: "Entrada 2"
                            },
                            model: {
                              value: _vm.horario.entrada2,
                              callback: function($$v) {
                                _vm.$set(_vm.horario, "entrada2", $$v)
                              },
                              expression: "horario.entrada2"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "1" } },
                        [
                          _c("v-text-field", {
                            directives: [
                              {
                                name: "mask",
                                rawName: "v-mask",
                                value: "##:##",
                                expression: "'##:##'"
                              }
                            ],
                            attrs: {
                              disabled:
                                _vm.horario.entrada == "00:00" ||
                                _vm.horario.salida == "00:00",
                              label: "Salida 2"
                            },
                            model: {
                              value: _vm.horario.salida2,
                              callback: function($$v) {
                                _vm.$set(_vm.horario, "salida2", $$v)
                              },
                              expression: "horario.salida2"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "3" } },
                        [
                          _c(
                            "v-btn",
                            {
                              staticClass: "white--text",
                              attrs: {
                                rounded: "",
                                depressed: "",
                                color: "blue"
                              },
                              on: { click: _vm.pushHorario }
                            },
                            [_vm._v("agregar")]
                          )
                        ],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-col",
                { attrs: { cols: "12", md: "8" } },
                [
                  _c("v-data-table", {
                    staticClass: "elevation-1",
                    attrs: {
                      "sort-by": "dia",
                      headers: _vm.headers,
                      items: _vm.empleado.horario,
                      "disable-pagination": "",
                      "hide-default-footer": "",
                      "item-key": "id"
                    },
                    scopedSlots: _vm._u(
                      [
                        {
                          key: "item.dia",
                          fn: function(ref) {
                            var item = ref.item
                            return [_vm._v(_vm._s(_vm._f("getday")(item.dia)))]
                          }
                        },
                        {
                          key: "item.action",
                          fn: function(ref) {
                            var item = ref.item
                            return [
                              _c(
                                "v-icon",
                                {
                                  attrs: { small: "", color: "blue" },
                                  on: {
                                    click: function($event) {
                                      return _vm.setHorario(item)
                                    }
                                  }
                                },
                                [_vm._v("mdi-pencil")]
                              ),
                              _vm._v(" "),
                              _c(
                                "v-icon",
                                {
                                  attrs: { small: "", color: "red" },
                                  on: {
                                    click: function($event) {
                                      return _vm.deleteHorario(item)
                                    }
                                  }
                                },
                                [_vm._v("mdi-trash-can")]
                              )
                            ]
                          }
                        }
                      ],
                      null,
                      false,
                      833037508
                    )
                  })
                ],
                1
              )
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _c("h3", { staticClass: "mt-5" }, [
        _vm._v("Horario para un día específico")
      ]),
      _vm._v(" "),
      _vm.empleado.id
        ? _c("horario-component", {
            attrs: {
              empleado_id: _vm.empleado.id,
              fechas: _vm.empleado.fechas,
              tiendas: _vm.tiendas
            }
          })
        : _vm._e(),
      _vm._v(" "),
      _c(
        "v-dialog",
        {
          attrs: { persistent: "", "max-width": "290" },
          model: {
            value: _vm.dialog,
            callback: function($$v) {
              _vm.dialog = $$v
            },
            expression: "dialog"
          }
        },
        [
          _c(
            "v-card",
            [
              _c("v-card-title", { staticClass: "headline" }, [
                _vm._v("Eliminar Empleado")
              ]),
              _vm._v(" "),
              _c("v-card-text", [
                _c("p", [_vm._v("Se eliminaran todas las citas asociadas")])
              ]),
              _vm._v(" "),
              _c(
                "v-card-actions",
                [
                  _c("v-spacer"),
                  _vm._v(" "),
                  _c(
                    "v-btn",
                    {
                      attrs: { loading: _vm.isloading, color: "red", dark: "" },
                      on: { click: _vm.deleteEmpleado }
                    },
                    [_vm._v("Eliminar")]
                  ),
                  _vm._v(" "),
                  _c(
                    "v-btn",
                    {
                      attrs: { color: "red", outlined: "", text: "" },
                      on: {
                        click: function($event) {
                          _vm.dialog = false
                        }
                      }
                    },
                    [_vm._v("Cancelar")]
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=template&id=29c1498b&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=template&id=29c1498b& ***!
  \*************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-container",
    [
      _c(
        "v-row",
        [
          _c(
            "v-col",
            { attrs: { cols: "12", md: "10" } },
            [
              _c(
                "v-row",
                { attrs: { dense: "", align: "center" } },
                [
                  _c(
                    "v-col",
                    { attrs: { cols: "12", md: "2" } },
                    [
                      _c("v-select", {
                        attrs: {
                          label: "Tiendas",
                          items: _vm.tiendas,
                          "item-text": "nombre",
                          "item-value": "id"
                        },
                        model: {
                          value: _vm.horario.app_tienda_id,
                          callback: function($$v) {
                            _vm.$set(_vm.horario, "app_tienda_id", $$v)
                          },
                          expression: "horario.app_tienda_id"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-col",
                    { attrs: { cols: "12", md: "2" } },
                    [
                      _c(
                        "v-menu",
                        {
                          ref: "menu",
                          attrs: {
                            "close-on-content-click": false,
                            "return-value": _vm.horario.fechas,
                            transition: "scale-transition",
                            "offset-y": "",
                            "min-width": "auto"
                          },
                          on: {
                            "update:returnValue": function($event) {
                              return _vm.$set(_vm.horario, "fechas", $event)
                            },
                            "update:return-value": function($event) {
                              return _vm.$set(_vm.horario, "fechas", $event)
                            }
                          },
                          scopedSlots: _vm._u([
                            {
                              key: "activator",
                              fn: function(ref) {
                                var on = ref.on
                                var attrs = ref.attrs
                                return [
                                  _c(
                                    "v-combobox",
                                    _vm._g(
                                      _vm._b(
                                        {
                                          attrs: {
                                            multiple: "",
                                            chips: "",
                                            "small-chips": "",
                                            label: "Fecha",
                                            "prepend-icon": "mdi-calendar"
                                          },
                                          model: {
                                            value: _vm.horario.fechas,
                                            callback: function($$v) {
                                              _vm.$set(
                                                _vm.horario,
                                                "fechas",
                                                $$v
                                              )
                                            },
                                            expression: "horario.fechas"
                                          }
                                        },
                                        "v-combobox",
                                        attrs,
                                        false
                                      ),
                                      on
                                    )
                                  )
                                ]
                              }
                            }
                          ]),
                          model: {
                            value: _vm.menu,
                            callback: function($$v) {
                              _vm.menu = $$v
                            },
                            expression: "menu"
                          }
                        },
                        [
                          _vm._v(" "),
                          _c(
                            "v-date-picker",
                            {
                              attrs: {
                                color: "green",
                                "first-day-of-week": "1",
                                multiple: "",
                                "no-title": "",
                                scrollable: ""
                              },
                              model: {
                                value: _vm.horario.fechas,
                                callback: function($$v) {
                                  _vm.$set(_vm.horario, "fechas", $$v)
                                },
                                expression: "horario.fechas"
                              }
                            },
                            [
                              _c("v-spacer"),
                              _vm._v(" "),
                              _c(
                                "v-btn",
                                {
                                  attrs: { text: "", color: "red" },
                                  on: {
                                    click: function($event) {
                                      _vm.menu = false
                                    }
                                  }
                                },
                                [_c("strong", [_vm._v("Cancelar")])]
                              ),
                              _vm._v(" "),
                              _c(
                                "v-btn",
                                {
                                  attrs: { text: "", color: "success" },
                                  on: {
                                    click: function($event) {
                                      return _vm.$refs.menu.save(
                                        _vm.horario.fechas
                                      )
                                    }
                                  }
                                },
                                [_c("strong", [_vm._v("OK")])]
                              )
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-col",
                    { attrs: { cols: "12", md: "1" } },
                    [
                      _c("v-text-field", {
                        directives: [
                          {
                            name: "mask",
                            rawName: "v-mask",
                            value: "##:##",
                            expression: "'##:##'"
                          }
                        ],
                        attrs: { label: "Entrada", required: "" },
                        model: {
                          value: _vm.horario.entrada,
                          callback: function($$v) {
                            _vm.$set(_vm.horario, "entrada", $$v)
                          },
                          expression: "horario.entrada"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-col",
                    { attrs: { cols: "12", md: "1" } },
                    [
                      _c("v-text-field", {
                        directives: [
                          {
                            name: "mask",
                            rawName: "v-mask",
                            value: "##:##",
                            expression: "'##:##'"
                          }
                        ],
                        attrs: { label: "Salida", required: "" },
                        model: {
                          value: _vm.horario.salida,
                          callback: function($$v) {
                            _vm.$set(_vm.horario, "salida", $$v)
                          },
                          expression: "horario.salida"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-col",
                    { attrs: { cols: "12", md: "1" } },
                    [
                      _c("v-text-field", {
                        directives: [
                          {
                            name: "mask",
                            rawName: "v-mask",
                            value: "##:##",
                            expression: "'##:##'"
                          }
                        ],
                        attrs: {
                          disabled:
                            _vm.horario.entrada == "00:00" ||
                            _vm.horario.salida == "00:00",
                          label: "Entrada 2"
                        },
                        model: {
                          value: _vm.horario.entrada2,
                          callback: function($$v) {
                            _vm.$set(_vm.horario, "entrada2", $$v)
                          },
                          expression: "horario.entrada2"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-col",
                    { attrs: { cols: "12", md: "1" } },
                    [
                      _c("v-text-field", {
                        directives: [
                          {
                            name: "mask",
                            rawName: "v-mask",
                            value: "##:##",
                            expression: "'##:##'"
                          }
                        ],
                        attrs: {
                          disabled:
                            _vm.horario.entrada == "00:00" ||
                            _vm.horario.salida == "00:00",
                          label: "Salida 2"
                        },
                        model: {
                          value: _vm.horario.salida2,
                          callback: function($$v) {
                            _vm.$set(_vm.horario, "salida2", $$v)
                          },
                          expression: "horario.salida2"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-col",
                    { attrs: { cols: "12", md: "3" } },
                    [
                      _c(
                        "v-btn",
                        {
                          staticClass: "white--text",
                          attrs: {
                            depressed: "",
                            rounded: "",
                            color: "success"
                          },
                          on: { click: _vm.guardarHorario }
                        },
                        [_vm._v("guardar")]
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-row",
        { attrs: { dense: "", align: "center" } },
        [
          _c(
            "v-col",
            { attrs: { cols: "12", md: "8" } },
            [
              _c("v-data-table", {
                staticClass: "elevation-1",
                attrs: {
                  headers: _vm.headers,
                  items: _vm.local_fechas,
                  "disable-pagination": "",
                  "hide-default-footer": "",
                  "item-key": "id",
                  "sort-by": ["app_tienda_id", "fecha"],
                  "sort-desc": [true, false],
                  "multi-sort": ""
                },
                scopedSlots: _vm._u([
                  {
                    key: "item.app_tienda_id",
                    fn: function(ref) {
                      var item = ref.item
                      return [
                        _vm._v(
                          " " +
                            _vm._s(
                              _vm._f("gettienda")(
                                item.app_tienda_id,
                                _vm.tiendas
                              )
                            ) +
                            " "
                        )
                      ]
                    }
                  },
                  {
                    key: "item.action",
                    fn: function(ref) {
                      var item = ref.item
                      return [
                        _c(
                          "v-icon",
                          {
                            attrs: { small: "", color: "blue" },
                            on: {
                              click: function($event) {
                                return _vm.setHorario(item)
                              }
                            }
                          },
                          [_vm._v("mdi-pencil")]
                        ),
                        _vm._v(" "),
                        _c(
                          "v-icon",
                          {
                            attrs: { small: "", color: "red" },
                            on: {
                              click: function($event) {
                                return _vm.deleteHorario(item)
                              }
                            }
                          },
                          [_vm._v("mdi-trash-can")]
                        )
                      ]
                    }
                  }
                ])
              })
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue":
/*!************************************************************************!*\
  !*** ./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AppFormEmpleados_vue_vue_type_template_id_4c693b1a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AppFormEmpleados.vue?vue&type=template&id=4c693b1a& */ "./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=template&id=4c693b1a&");
/* harmony import */ var _AppFormEmpleados_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AppFormEmpleados.vue?vue&type=script&lang=js& */ "./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AppFormEmpleados_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AppFormEmpleados_vue_vue_type_template_id_4c693b1a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _AppFormEmpleados_vue_vue_type_template_id_4c693b1a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AppFormEmpleados_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./AppFormEmpleados.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AppFormEmpleados_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=template&id=4c693b1a&":
/*!*******************************************************************************************************!*\
  !*** ./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=template&id=4c693b1a& ***!
  \*******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AppFormEmpleados_vue_vue_type_template_id_4c693b1a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./AppFormEmpleados.vue?vue&type=template&id=4c693b1a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/app_empleados/componentes/AppFormEmpleados.vue?vue&type=template&id=4c693b1a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AppFormEmpleados_vue_vue_type_template_id_4c693b1a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AppFormEmpleados_vue_vue_type_template_id_4c693b1a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./vue_app/modulos/app_empleados/componentes/horarioComponent.vue":
/*!************************************************************************!*\
  !*** ./vue_app/modulos/app_empleados/componentes/horarioComponent.vue ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _horarioComponent_vue_vue_type_template_id_29c1498b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./horarioComponent.vue?vue&type=template&id=29c1498b& */ "./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=template&id=29c1498b&");
/* harmony import */ var _horarioComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./horarioComponent.vue?vue&type=script&lang=js& */ "./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _horarioComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _horarioComponent_vue_vue_type_template_id_29c1498b___WEBPACK_IMPORTED_MODULE_0__["render"],
  _horarioComponent_vue_vue_type_template_id_29c1498b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "vue_app/modulos/app_empleados/componentes/horarioComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_horarioComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./horarioComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_horarioComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=template&id=29c1498b&":
/*!*******************************************************************************************************!*\
  !*** ./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=template&id=29c1498b& ***!
  \*******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_horarioComponent_vue_vue_type_template_id_29c1498b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./horarioComponent.vue?vue&type=template&id=29c1498b& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/app_empleados/componentes/horarioComponent.vue?vue&type=template&id=29c1498b&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_horarioComponent_vue_vue_type_template_id_29c1498b___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_horarioComponent_vue_vue_type_template_id_29c1498b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);