(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mixins_data_mixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../mixins/data_mixin */ "./vue_app/modulos/citas/mixins/data_mixin.js");
/* harmony import */ var _mixins_calendar_basic_mixin__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../mixins/calendar_basic_mixin */ "./vue_app/modulos/citas/mixins/calendar_basic_mixin.js");
/* harmony import */ var _empleadoComponent__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./empleadoComponent */ "./vue_app/modulos/citas/componentes/empleadoComponent.vue");
/* harmony import */ var _eventoComponent__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./eventoComponent */ "./vue_app/modulos/citas/componentes/eventoComponent.vue");
/* harmony import */ var vuejs_toggle_switch__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuejs-toggle-switch */ "./node_modules/vuejs-toggle-switch/dist/ToggleSwitch.common.js");
/* harmony import */ var vuejs_toggle_switch__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(vuejs_toggle_switch__WEBPACK_IMPORTED_MODULE_4__);
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
    empleadoComponent: _empleadoComponent__WEBPACK_IMPORTED_MODULE_2__["default"],
    eventoComponent: _eventoComponent__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  mixins: [_mixins_data_mixin__WEBPACK_IMPORTED_MODULE_0__["data_mixin"], _mixins_calendar_basic_mixin__WEBPACK_IMPORTED_MODULE_1__["calendar_basic_mixin"]],
  data: function data() {
    return {
      tipo: null,
      scroll_value: 0,
      slider: 26,
      dia_actual: moment().format('YYYY-MM-DD').substring(0, 10),
      current_day_inmutable: moment().format('YYYY-MM-DD').substring(0, 10),
      entrada: '08:00',
      salida: '21:30',
      intervalos: [],
      citas: [],
      dialogo: '',
      overlay: false
    };
  },
  watch: {
    'dia_actual': function dia_actual(n) {
      var base_url = this.$route.query.tipo == 'peluqueria' ? 'citas-peluqueria?tipo=peluqueria' : 'citas-clinica?tipo=clinica';
      this.$router.push("".concat(base_url))["catch"](function () {});
      this.agregarCitas(n);
      this.setWeekDay(n);
    },
    'tienda': {
      immediate: true,
      handler: function handler(n) {
        this.tienda = parseInt(this.tienda);

        if (this.tienda) {
          this.overlay = true;
        }

        n ? this.getData(this.$route.query.tipo, n) : null;
      }
    }
  },
  created: function created() {
    this.overlay = false, this.calcularIntervalos();
    this.getTiendas();
    this.tipo = this.$route.query.tipo;
  },
  methods: {
    semana: function semana() {
      //Ponemos el calendario en modo semana y seteamos la url
      this.type = "week";
      /*let base_url = this.$route.query.tipo == 'peluqueria' ? 'citas-peluqueria?tipo=peluqueria' : 'citas-clinica?tipo=clinica'
      this.$router.push(`${base_url}`).catch(() => {});*/
    },
    scrollFunction: function scrollFunction(e) {
      this.$refs.false_scroll.scrollLeft = e.target.scrollLeft;
    },
    falseScrollFunction: function falseScrollFunction(e) {
      this.$refs.calendar_wrap.scrollLeft = e.target.scrollLeft;
    },
    getCitas: function getCitas(empleado, dia) {
      return this.map_citas["".concat(empleado.nombre, "_").concat(dia)];
    },
    getHorario: function getHorario(empleado, dia) {
      var _this = this;

      var horario_especial = undefined;
      var actual = moment("".concat(dia), 'YYYY-MM-DD');
      var fecha_revision = moment('2021-11-15', 'YYYY-MM-DD'); // Comprobamos si el empleado tiene un horario especifico ( variable fecha del array en crearIntervalos(n, dia_actual)) 
      // si no tiene horario especifico asignamos la entrada y salida de este dia actual ( habitual )
      // y verificamos que el id del horario del empleado sea de la tienda seleccionada

      if (empleado.fecha.length == 0) {
        horario_especial = this.map_horario["".concat(empleado.id, "_").concat(moment(dia).weekday())];
      } // si tiene horario especifico asignamos la entrada y salida de este dia actual ( especifico ) 
      else {
          var horarioHabitual = [];
          var horarioEspecifico = [];
          var horarioLibre = [];
          var diaEspecifico = false;
          var diaHabitual = false;
          var diaLibre = false;
          horario_especial = undefined; // para evitar la entrada en todos los dias especificos y que muestre de manera erroneo el horario
          //  creamos una variable flag para marcar la entrada

          var diapintado = false; //  recorremos el horario especifico y asignamos la entrada y salida de este dia especifico

          empleado.fecha.forEach(function (especifico) {
            // Seteamos en variables la fecha especifica del dia recorrido y la fecha actual para realizar la comprobacion
            var fecha = moment("".concat(especifico.fecha), 'YYYY-MM-DD'); // Verificamos que sean iguales para asignar la entrada y salida

            if (_this.tienda == especifico.app_tienda_id) {
              if (JSON.stringify(fecha) == JSON.stringify(actual)) {
                //si es undefine inicializo el array
                if (horarioEspecifico == undefined
                /*|| diapintado == false*/
                ) {
                    horarioEspecifico = [];
                  } //Añadimos en horario especifico


                horarioEspecifico.push({
                  app_empleado_id: empleado.id,
                  app_tienda_id: especifico.app_tienda_id,
                  dia: moment(dia).weekday(),
                  entrada: especifico.entrada,
                  salida: especifico.salida
                }); // Si los dias coinciden marcamos el flag como true para no realice mas comprobaciones y marque mal el horario
                //Indicamos diaEspecifico a true para confirmar que se existe horario específico
                //diapintado = true;

                diaEspecifico = true;
              } else {
                // Si los dias no coinciden marcamos el flag y el horario como habitual
                // if (diapintado == false) {
                //diapintado = true;
                //diaHabitual = true
                //añadimos a horario habitual e indicamos a true el diahabitual
                diaHabitual = true;
                horarioHabitual = _this.map_horario["".concat(empleado.id, "_").concat(moment(dia).weekday())]; //}                                   
              }
            } else {
              if (JSON.stringify(fecha) == JSON.stringify(actual)) {
                horarioLibre = undefined; //diapintado = true;

                diaLibre = true;
              }
            }
          }); //comprobamos si el día actual es específico o habitual y dependiendo de esto se lo asignamos a horario_especial para devolverlo

          if (diaEspecifico) {
            horario_especial = horarioEspecifico;
          } else if (diaLibre) {
            horario_especial = horarioLibre;
          } else if (diaHabitual) {
            horario_especial = horarioHabitual;
          }
        } // Comprobamos si el empleado tiene vacaciones ( variable fecha del array en crearIntervalos(n, dia_actual)) 
      // si no tiene vacaciones asignamos la entrada y salida de este dia actual ( habitual )


      if (empleado.vacaciones.length > 0) {
        // para evitar la entrada en todos los dias de vacaciones y que muestre de manera erroneo el horario
        //  creamos una variable flag para marcar la entrada
        var diavacaciones = false; //  recorremos el horario vacaciones y asignamos la entrada y salida de este dia vacaciones

        empleado.vacaciones.forEach(function (vacaciones) {
          // Seteamos en variables la fecha especifica del dia recorrido y la fecha actual para realizar la comprobacion
          var fechavacaciones = moment("".concat(vacaciones.fecha), 'YYYY-MM-DD HH:mm');
          var actual = moment("".concat(dia), 'YYYY-MM-DD HH:mm'); // Verificamos que sean iguales para asignar la entrada y salida

          if (JSON.stringify(fechavacaciones) == JSON.stringify(actual)) {
            horario_especial = undefined; // Si los dias coinciden marcamos el flag como true para no realice mas comprobaciones y marque mal el horario

            diavacaciones = true;
          }
        });
      }

      return horario_especial;
    },
    getFechas: function getFechas(empleado, dia) {
      return this.map_fecha["".concat(empleado.id, "_").concat(dia)];
    },
    selectDay: function selectDay(weekday) {
      this.weekday = weekday;
      this.dia_actual = weekday.full_date;
      this.type = 'day';
    },
    agregarCitas: function agregarCitas(dia_actual) {
      var _this2 = this;

      // Lista las citas de la semana actual
      axios.get("api/app/geteventsbymonth/".concat(dia_actual)).then(function (res) {
        _this2.citas = res.data;
      });
    },
    agregarCita: function agregarCita(cita) {
      var start_of_week = this.week_days[0].full_date;
      var end_of_week = this.week_days[this.week_days.length - 1].full_date;
      var is_beetween = moment(cita.start.substring(0, 10)).isBetween(start_of_week, end_of_week, undefined, '[]');
      this.deleteCita(cita);

      if (is_beetween) {
        this.citas.push(cita);
      }

      this.agregarCitas(this.dia_actual);
    },
    deleteCita: function deleteCita(cita) {
      var index = this.citas.findIndex(function (element) {
        return element.id == cita.id;
      });

      if (index > -1) {
        this.citas.splice(index, 1);
      }
    },
    calcularIntervalos: function calcularIntervalos() {
      var start = moment("2021-03-26 ".concat(this.entrada), 'YYYY-MM-DD HH:mm');
      var end = moment("2021-03-26 ".concat(this.salida), 'YYYY-MM-DD HH:mm');
      var diff = end.diff(start, 'minutes');

      var intervalos = _.range(diff / 30);

      this.intervalos = intervalos.map(function (element, index) {
        return start.clone().add(index * 30, 'minutes').format('HH:mm');
      });
    },
    resetClientes: function resetClientes() {
      var _this3 = this;

      this.overlay = true;
      axios.get('api/app/getusuarios').then(function (res) {
        _this3.clientes = res.data;
        _this3.overlay = false;
        _this3.dialogo = false;
      }, function (res) {
        _this3.$toast.error('Error obteniendo Usuarios');
      });
    },
    abrirbusqueda: function abrirbusqueda() {
      // Abre busqueda
      this.dialogobuscar = true;
    }
  },
  computed: {
    isloading: function isloading() {
      return this.$store.getters.getloading;
    },
    month: function month() {
      return moment(this.dia_actual).format('MMMM');
    },
    map_citas: function map_citas() {
      var map = {};
      this.citas.forEach(function (x) {
        var fecha = x.start.substring(0, 10);
        var ref = "".concat(x.empleado, "_").concat(fecha);
        (map[ref] = map[ref] || []).push(x);
      });
      return map;
    },
    map_horario: function map_horario() {
      var horarios = this.empleados.flatMap(function (empleado) {
        return empleado.horario;
      });
      var map = {};
      horarios.forEach(function (x) {
        var ref = "".concat(x.app_empleado_id, "_").concat(x.dia);
        (map[ref] = map[ref] || []).push(x);
      });
      return map;
    },
    map_fecha: function map_fecha() {
      var fechas = this.empleados.flatMap(function (empleado) {
        return empleado.fecha;
      });
      var map = {};
      fechas.forEach(function (x) {
        var ref = "".concat(x.app_empleado_id, "_").concat(x.fecha);
        (map[ref] = map[ref] || []).push(x);
      });
      return map;
    },
    week_days: function week_days() {
      var current_date = moment(this.dia_actual);
      var week_start = current_date.clone().startOf('isoweek');

      var range_dates = _.range(7).map(function (x) {
        var fecha = moment(week_start).add(x, 'days');
        return {
          numero_dia: fecha.format('DD'),
          nombre_dia: fecha.format('dddd'),
          full_date: fecha.format('YYYY-MM-DD')
        };
      });

      return range_dates;
    },
    set_week_days: function set_week_days() {
      var _this4 = this;

      if (this.weekday && this.type == 'day') {
        var i = this.week_days.findIndex(function (x) {
          return x.full_date == _this4.weekday.full_date;
        });
        return [this.week_days[i]];
      } else {
        return this.week_days;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _handlers_eventbus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../handlers/eventbus */ "./vue_app/modulos/citas/handlers/eventbus.js");
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
  props: ['intervalos', 'empleado', 'citas', 'horario', 'dia_actual', 'interval_height', 'fechas', 'type', 'app_tienda_id'],
  data: function data() {
    return {
      local_citas: [],
      local_intervalos: {}
    };
  },
  watch: {
    'citas': {
      immediate: true,
      handler: function handler(n) {
        this.$nextTick(function () {
          this.local_citas = n;
        });
      }
    },
    'horario': {
      immediate: true,
      handler: function handler(n) {
        n ? this.agregarHorarioPorEmpleado(n, this.dia_actual) : null;
      }
    },
    'fechas': {
      /*immediate: true,
      handler(n) {
          n ? this.sobreEscribirHorario(n, this.dia_actual) : null
      }*/
    },
    'dia_actual': {
      handler: function handler(n) {
        this.horario ? this.agregarHorarioPorEmpleado(this.horario, n) : null;
      }
    },
    'app_tienda_id': {
      inmediate: true,
      handler: function handler(n) {
        this.local_intervalos = {};
      }
    }
  },
  methods: {
    // crearIntervalos(n, dia_actual) {         
    //     let intervalos = n.forEach(habitual => {
    //             // Comprobamos los intervalos de horario de los trabajadores para verificar 
    //             // su horario habitual, horario especifico y sus vacaciones
    //             // inicializamos las variable de entrada y salida
    //             let start = '';
    //             let end = '';
    //             // Comprobamos si el empleado tiene un horario especifico ( variable fecha del array en crearIntervalos(n, dia_actual)) 
    //             // si no tiene horario especifico asignamos la entrada y salida de este dia actual ( habitual )
    //             // y verificamos que el id del horario del empleado sea de la tienda seleccionada
    //                 if (this.empleado.fecha.length == 0) 
    //                 {
    //                     start = moment(`${dia_actual} ${habitual.entrada}`, 'YYYY-MM-DD HH:mm')
    //                     end = moment(`${dia_actual} ${habitual.salida}`, 'YYYY-MM-DD HH:mm')
    //                 }
    //                 // si tiene horario especifico asignamos la entrada y salida de este dia actual ( especifico ) 
    //                 else
    //                 {
    //                     // para evitar la entrada en todos los dias especificos y que muestre de manera erroneo el horario
    //                     //  creamos una variable flag para marcar la entrada
    //                     let diapintado = false;
    //                     //  recorremos el horario especifico y asignamos la entrada y salida de este dia especifico
    //                     this.empleado.fecha.forEach(especifico => {
    //                         // Seteamos en variables la fecha especifica del dia recorrido y la fecha actual para realizar la comprobacion
    //                         let fecha = moment(`${especifico.fecha}`, 'YYYY-MM-DD HH:mm');
    //                         let actual = moment(`${dia_actual}`, 'YYYY-MM-DD HH:mm');
    //                         // Verificamos que sean iguales para asignar la entrada y salida
    //                         if (this.app_tienda_id == especifico.app_tienda_id)
    //                         {
    //                             if (JSON.stringify(fecha) == JSON.stringify(actual))
    //                             {
    //                                 start = moment(`${dia_actual} ${especifico.entrada}`, 'YYYY-MM-DD HH:mm')
    //                                 end = moment(`${dia_actual} ${especifico.salida}`, 'YYYY-MM-DD HH:mm')
    //                                 // Si los dias coinciden marcamos el flag como true para no realice mas comprobaciones y marque mal el horario
    //                                 diapintado = true;
    //                             }
    //                             else
    //                             {                     
    //                                 // Si los dias no coinciden marcamos el flag y el horario como habitual
    //                                 if (diapintado == false) {
    //                                     start = moment(`${dia_actual} ${habitual.entrada}`, 'YYYY-MM-DD HH:mm')
    //                                     end = moment(`${dia_actual} ${habitual.salida}`, 'YYYY-MM-DD HH:mm')
    //                                 }                                   
    //                             }
    //                         }
    //                         else
    //                         {
    //                         // En caso de que trabaje en otra localizacion diferente a la habitual marcara el dia como no habil
    //                             if (JSON.stringify(fecha) == JSON.stringify(actual) && diapintado == false) {
    //                                 let hora = '00:00';
    //                                 start = moment(`${dia_actual} ${hora}`, 'YYYY-MM-DD HH:mm');
    //                                 end = moment(`${dia_actual} ${hora}`, 'YYYY-MM-DD HH:mm');
    //                                 diapintado = true;
    //                             }
    //                         }
    //                     })
    //                 }
    //                 // Comprobamos si el empleado tiene vacaciones ( variable fecha del array en crearIntervalos(n, dia_actual)) 
    //                 // si no tiene vacaciones asignamos la entrada y salida de este dia actual ( habitual )
    //                 if (this.empleado.vacaciones.length == 0) 
    //                 {
    //                     start = moment(`${dia_actual} ${habitual.entrada}`, 'YYYY-MM-DD HH:mm')
    //                     end = moment(`${dia_actual} ${habitual.salida}`, 'YYYY-MM-DD HH:mm')
    //                 }
    //                 // si tiene vacaciones asignamos la entrada y salida de este dia actual ( vacaciones ) 
    //                 else
    //                 {
    //                     // para evitar la entrada en todos los dias de vacaciones y que muestre de manera erroneo el horario
    //                     //  creamos una variable flag para marcar la entrada
    //                     let diavacaciones = false;
    //                     //  recorremos el horario vacaciones y asignamos la entrada y salida de este dia vacaciones
    //                     this.empleado.vacaciones.forEach(vacaciones => {
    //                         // Seteamos en variables la fecha especifica del dia recorrido y la fecha actual para realizar la comprobacion
    //                         let fechavacaciones = moment(`${vacaciones.fecha}`, 'YYYY-MM-DD HH:mm');
    //                         let actual = moment(`${dia_actual}`, 'YYYY-MM-DD HH:mm');
    //                         // Verificamos que sean iguales para asignar la entrada y salida
    //                         if (JSON.stringify(fechavacaciones) == JSON.stringify(actual))
    //                         {
    //                             let hora = '00:00';
    //                             start = moment(`${dia_actual} ${hora}`, 'YYYY-MM-DD HH:mm')
    //                             end = moment(`${dia_actual} ${hora}`, 'YYYY-MM-DD HH:mm')
    //                             // Si los dias coinciden marcamos el flag como true para no realice mas comprobaciones y marque mal el horario
    //                             diavacaciones = true;
    //                         }
    //                     })
    //                 }  
    //             // Despues de asignar la entrada y salida diaria del trabajador en cualquiera de los horarios 
    //             // horario habitual, horario especifico y/o vacaciones asignamos cada seccion de 30 minutos al empleado para citas
    //             let diff = end.diff(start, 'minutes')
    //             let intervalos = _.range((diff / 30))
    //             intervalos.forEach((element, index) => {
    //                 let n = start.clone().add(index * 30, 'minutes').format('YYYY-MM-DD_HH:mm')
    //                 let ref = `${this.empleado.nombre}_${n}`;
    //                 (this.local_intervalos[ref] = this.local_intervalos[ref] || []).push(ref)
    //             })
    //     })
    // },
    crearIntervalos: function crearIntervalos(n, dia_actual) {
      var _this = this;

      var intervalos = n.forEach(function (element) {
        var start = moment("".concat(dia_actual, " ").concat(element.entrada), 'YYYY-MM-DD HH:mm');
        var end = moment("".concat(dia_actual, " ").concat(element.salida), 'YYYY-MM-DD HH:mm');
        var diff = end.diff(start, 'minutes');

        var intervalos = _.range(diff / 30);

        intervalos.forEach(function (element, index) {
          var n = start.clone().add(index * 30, 'minutes').format('YYYY-MM-DD_HH:mm');
          var ref = "".concat(_this.empleado.nombre, "_").concat(n);
          (_this.local_intervalos[ref] = _this.local_intervalos[ref] || []).push(ref);
        });
      });
    },
    sobreEscribirHorario: function sobreEscribirHorario(n, dia_actual) {
      this.local_intervalos = {};
      this.crearIntervalos(n, dia_actual);
    },
    agregarHorarioPorEmpleado: function agregarHorarioPorEmpleado(n, dia_actual) {
      var fecha_revision = moment('2021-11-15', 'YYYY-MM-DD');

      if (this.fechas && this.fechas.length > 0) {
        this.local_intervalos = {};
        return this.crearIntervalos(this.fechas, dia_actual);
      }

      this.crearIntervalos(n, dia_actual);
    },
    empleadoHorario: function empleadoHorario(ref) {
      return this.local_intervalos[ref];
    },
    openForm: function openForm() {
      _handlers_eventbus__WEBPACK_IMPORTED_MODULE_0__["EventBus"].$emit('open_form', {
        app_empleado_id: this.empleado.id,
        fecha: this.dia_actual
      });
    },
    setCita: function setCita(cita) {
      _handlers_eventbus__WEBPACK_IMPORTED_MODULE_0__["EventBus"].$emit('set_cita', cita);
    },
    timeToY: function timeToY(cita) {
      var ref_date = "".concat(cita.start.substring(0, 10), "_").concat(cita.start.substring(11));
      var ref_name = "".concat(this.empleado.nombre, "_").concat(ref_date);

      if (this.$refs[ref_name] !== undefined && this.$refs[ref_name][0]) {
        return {
          display: 'block',
          top: "".concat(this.$refs[ref_name][0].offsetTop, "px"),
          height: "".concat(cita.duracion / 30 * this.interval_height, "px"),
          backgroundColor: cita.color
        };
      }

      return {
        display: 'none'
      };
    },
    minutesToPixels: function minutesToPixels(duracion) {
      return duracion / 30 * this.interval_height;
    },
    getcolor: function getcolor() {
      return "#".concat((Math.random() * 0xFFFFFF << 0).toString(16));
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _handlers_eventbus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../handlers/eventbus */ "./vue_app/modulos/citas/handlers/eventbus.js");
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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
  props: ['empleados', 'clientes', 'servicios', 'tipo', 'app_tienda_id'],
  data: function data() {
    var _ref;

    return _ref = {
      tipos_tamanyo: [],
      tipos_pelo: [],
      tamanyo_selec: {
        id: null,
        nombre: null,
        peso: ""
      },
      editar: 'editar',
      nuevo: 'nuevo',
      direccion_recogida: [],
      direccion_entrega: [],
      filtrohoras: false,
      dialogo: false,
      dialogocita: false,
      dialogobuscar: false,
      dialogocancelar: false,
      dialogogomascota: false,
      toggle_exclusive: null,
      usuario: {
        id: '',
        nombre: '',
        apellidos: '',
        email: '',
        telefono: '',
        codigo: '',
        observaciones: '',
        avatar: null,
        password: null,
        direccion: []
      },
      usuarioEdit: {
        id: '',
        nombre: '',
        apellidos: '',
        email: '',
        telefono: '',
        adoptar: 0,
        donar: 0,
        codigo: '',
        observaciones: '',
        avatar: null,
        password: null,
        direccion: '',
        profesion: '',
        consulta: '',
        antecedentes: '',
        tratamiento: ''
      },
      local_mascota: {
        id: '',
        app_usuario_id: '',
        nombre: '',
        Fecha_Nacimiento: '',
        raza: '',
        sexo: '',
        tamanyo: '',
        pelo: '',
        peso: '',
        color: '',
        Adoptable: '',
        seccion_id: '',
        imagen: null,
        observaciones: '',
        codigo: '',
        imagen_path: null
      },
      secciones: [],
      dialog: false,
      horas: [],
      mascotas: [],
      mascota: {
        historial: [],
        usuario: {
          observaciones: ''
        }
      },
      app_usuario_id: null,
      local_empleados: [],
      local_horario: [],
      evento: {
        id: null,
        app_empleado_id: null,
        app_usuario_id: null,
        app_tienda_id: this.app_tienda_id,
        app_mascota_id: null,
        tipo_id: 1,
        color: null,
        start: null,
        end: null,
        duracion: null,
        servicios: [],
        fecha: null,
        observacionesMascota: '',
        observacionesUsuario: '',
        confirmada: 1,
        recogida: 0,
        direccion_recogida: null,
        direccion_entrega: null,
        pago: 0,
        precio: ''
      },
      citapet: {
        id: null,
        mascota: null,
        tamanyo: null,
        pelo: null,
        raza: null,
        tipo: null,
        tienda: null,
        servicios: null,
        start: null,
        start_format: null
      },
      citacli: {
        id: null,
        tipo: null,
        empleado: '',
        tienda: null,
        servicios: null,
        start: null,
        start_format: null
      },
      dataItem: [],
      dataIdemp: '',
      editable: false,
      IdEmpleadoCita: ''
    }, _defineProperty(_ref, "nuevo", true), _defineProperty(_ref, "idEmpFormulario", ''), _defineProperty(_ref, "evento_nuevo", true), _defineProperty(_ref, "mascotaEdit", []), _defineProperty(_ref, "overlay", false), _ref;
  },
  watch: {
    'evento.servicios': function eventoServicios(n) {
      if (n) {
        this.evento.duracion = n.reduce(function (acc, x) {
          return acc + x.duracion;
        }, 0);
      }
    },
    'evento.app_usuario_id': function eventoApp_usuario_id(n) {
      if (this.evento_nuevo == true) {// this.getMascotas(n, true)
        //this.getDirecciones(n)
      } else {
        this.evento_nuevo = true;
      }
    },
    'mascota': function mascota(n) {
      this.evento.app_mascota_id = n ? n.id : null;
    },
    'usuario': function usuario(n) {
      this.evento.app_usuario_id = n ? n.id : null;
    },
    'empleados': function empleados(n) {
      this.local_empleados = JSON.parse(JSON.stringify(n));
      this.local_empleados.unshift({
        id: null,
        nombre: ''
      });
    }
  },
  created: function created() {
    var _this = this;

    //this.obtenerTiposPelo();
    //this.obtenerTiposTamanyo();
    //this.getSecciones();
    this.$parent.$on('open_dialog', function () {
      _this.dialog = true;
    });
    this.$parent.$on('abrirbusqueda', function () {
      _this.dialogobuscar = true;
    });
    _handlers_eventbus__WEBPACK_IMPORTED_MODULE_0__["EventBus"].$on('open_form', this.openForm);
    _handlers_eventbus__WEBPACK_IMPORTED_MODULE_0__["EventBus"].$on('set_cita', function (cita) {
      _this.evento_nuevo = false;
      _this.dialog = true;
      _this.evento = Object.assign({}, cita);
      _this.evento.fecha = cita.start.substring(0, 10);
      _this.evento.app_tienda_id = _this.app_tienda_id;

      _this.getMascotas(cita.app_usuario_id, false);

      _this.setUsuario(cita.app_usuario_id);

      _this.IdEmpleadoCita = _this.evento.app_empleado_id;
      _this.idEmpFormulario = _this.evento.app_empleado_id;

      _this.buscarDisponible();
    });
  },
  methods: {
    /*obtenerTiposPelo(){
        axios.get('api/app/get-tipos-pelo').then(res => {
            this.tipos_pelo = res.data
        }, err => {
            this.$toast.error('Error consultando Tipos de pelo')
        })
    },*/

    /*obtenerTiposTamanyo(){
        axios.get('api/app/get-tipos-tamanyos').then(res => {
            this.tipos_tamanyo = res.data
        }, err => {
            this.$toast.error('Error consultando tipos de tamaños')
        })
    },*/
    setUsuario: function setUsuario(id_usuario) {
      var _this2 = this;

      this.clientes.forEach(function (element) {
        if (element.id == id_usuario) {
          _this2.usuario = element;
        }
      });
    },
    editCostumer: function editCostumer(tipo) {
      // Abre formulario con datos o no segun sea el boton pulsado nuevo o esitar usuario
      if (tipo == 'editar') {
        this.usuarioEdit = Object.assign({}, this.usuario);
      }

      if (tipo == 'nuevo') {
        this.usuarioEdit = {
          id: '',
          nombre: '',
          apellidos: '',
          email: '',
          telefono: '',
          adoptar: 0,
          donar: 0,
          codigo: '',
          observaciones: '',
          avatar: null,
          password: null,
          direccion: '',
          profesion: '',
          consulta: '',
          antecedentes: '',
          tratamiento: ''
        }; //this.usuario = [];
      }
    },
    editPet: function editPet(tipo) {
      // Abre formulario con datos o no segun sea el boton pulsado nueva o editar mascota
      if (this.evento.app_mascota_id != null && tipo == 'editar') {
        this.getPetEdit(this.evento.app_mascota_id);
      }

      if (this.evento.app_mascota_id != null && tipo == 'nuevo') {
        this.tamanyo_selec = {
          id: null,
          nombre: null,
          peso: ""
        };
        this.local_mascota = {
          id: '',
          app_usuario_id: '',
          nombre: '',
          Fecha_Nacimiento: '',
          raza: '',
          sexo: '',
          tamanyo: '',
          pelo: '',
          peso: '',
          color: '',
          Adoptable: '',
          seccion_id: '',
          imagen: null,
          observaciones: '',
          codigo: '',
          imagen_path: null
        };
      }
    },
    getUsuarioEdit: function getUsuarioEdit(usuario_id) {
      var _this3 = this;

      // Obtiene el usuario a editar
      axios.get("api/app/getusuario/".concat(usuario_id)).then(function (res) {
        //this.usuarioEdit = res.data;
        _this3.usuario = res.data; //this.usuarioEdit;
        //this.evento.observacionesUsuario = this.usuario.observaciones;
        //this.usuarioEdit.id = this.app_usuario_id;
      }, function (res) {
        _this3.$toast.error('Algo ha salido mal');
      });
    },
    getPetEdit: function getPetEdit(mascota_id) {
      var _this4 = this;

      // Obtiene la mascota a editar
      this.local_mascota = Object.assign({}, this.mascota);
      this.tipos_tamanyo.forEach(function (tamanyo) {
        if (tamanyo.id == _this4.local_mascota.tamanyo) {
          _this4.tamanyo_selec = tamanyo;
        }
      });
    },
    getDirecciones: function getDirecciones(id_usuario) {
      var _this5 = this;

      // Obtiene direcciones de usuario
      this.clientes.forEach(function (element) {
        if (element.id == id_usuario) {
          _this5.direccion_recogida = element.direccion;
          _this5.direccion_entrega = element.direccion;
        }
      });
    },
    getItemText: function getItemText(item) {
      // Concatena nombre y apellidos para busqueda
      return "".concat(item.apellidos, " ").concat(item.nombre);
    },
    openForm: function openForm(data) {
      // Abre formulario pinchando en hora vacia
      this.dialog = true;
      this.evento.fecha = data.fecha;
      this.evento.app_tienda_id = this.app_tienda_id;
      this.evento.app_empleado_id = data.app_empleado_id;
    },
    saveUsuario: function saveUsuario() {
      var _this6 = this;

      // crea nuevo usuario desde cita
      //this.usuario.id = this.evento.app_usuario_id;
      axios.post("api/app/saveusuario", this.usuarioEdit).then(function (res) {
        //this.props= ['empleados', 'clientes', 'servicios', 'isloading'] 
        _this6.resetClientes();

        _this6.usuario = res.data; //this.evento.app_usuario_id = res.data.id;
        //this.app_usuario_id = res.data.id;

        _this6.$toast.sucs('Usuario Almacenado Correctamente');

        _this6.dialogo = false;
      }, function (res) {
        _this6.$toast.error('Error: ' + res.response.data.mensaje);
      });
    },
    guardarMascota: function guardarMascota() {
      var _this7 = this;

      // crea nueva mascota desde cita
      if (this.evento.app_usuario_id == '') return;
      this.local_mascota.tamanyo = this.tamanyo_selec.id;
      var usuario_id = this.evento.app_usuario_id;
      this.local_mascota.app_usuario_id = usuario_id;
      axios.post("api/app/save-mascota-from-user/".concat(usuario_id), this.local_mascota).then(function (res) {
        _this7.evento.app_mascota_id = res.data.id;

        _this7.getMascotas(usuario_id, false);

        _this7.dialogogomascota = false;

        _this7.$toast.sucs('Mascota Almacenada Correctamente');

        _this7.resetMascota();
      }, function (res) {
        _this7.$toast.error('Error guardando mascota');
      });
    },
    resetClientes: function resetClientes() {
      // Recarga el listado de clientes al almacenar uno nuevo
      this.$emit('resetClientes');
    },

    /*getSecciones() {  // Obtiene Tipo de animal
        axios.get(`api/get-secciones`).then(res => {
            this.secciones = res.data
        })
    },*/
    isSelect: function isSelect(item) {
      // Color segun servicio seleccionado o no             
      var index = this.evento.servicios.findIndex(function (x) {
        return x.id == item.id;
      });
      return index > -1 ? 'orange' : 'green darken-1';
    },
    isSelect2: function isSelect2(item, empleadoId) {
      // Color de horario seleccionado   
      var itemhora = '';

      if (this.evento.start != null) {
        itemhora = this.evento.start.substring(11, 16);
      }

      if (item == itemhora && this.dataItem == '' && this.IdEmpleadoCita == empleadoId || this.dataItem == item && this.IdEmpleadoCita == empleadoId) {
        this.dataItem = item;
        this.editable = true;
        return 'green lighten-4';
      }

      return 'grey lighten-3';
    },
    asignarServicio: function asignarServicio(item) {
      // Evento de seleccion de servicio
      var index = this.evento.servicios.findIndex(function (x) {
        return x.id == item.id;
      });

      if (index == -1) {
        this.evento.servicios.push(item);
      } else {
        this.evento.servicios.splice(index, 1);
      }

      this.buscarDisponible();
    },
    confirmarCita: function confirmarCita() {
      var _this8 = this;

      // boton de cita confirmada o sin confirmar
      axios.get("api/app/confirmar-cita/".concat(this.evento.id)).then(function (res) {
        _this8.evento.confirmada = res.data.confirmada;

        _this8.$toast.sucs('Estado actualizado');

        _this8.$store.dispatch('getNotificaciones');
      }, function (res) {
        _this8.$toast.warn('Error cambiando estado');
      });
    },
    buscarDisponible: function buscarDisponible() {
      var _this9 = this;

      // Evento boton busca disponible
      if (this.evento.fecha == null) {
        this.evento.fecha = moment().format('YYYY-MM-DD');
      }

      var data = {
        id: this.evento.id,
        fecha: this.evento.fecha,
        tienda_id: this.app_tienda_id,
        tipo: this.tipo,
        empleado_id: this.evento.app_empleado_id
      };

      if (this.evento.servicios.length >= 0 && data.fecha == null && data.empleado_id == null && this.nuevo == false || // Formulario vacio boton nuevo directo
      this.evento.servicios.length > 0 && data.fecha == null && data.empleado_id == null && this.nuevo == false || // Con empleado sin fecha                    
      this.evento.servicios.length == 0 && data.fecha == null && data.empleado_id != null && this.nuevo == false || // Sin empleado sin fecha 
      this.evento.servicios.length == 0 && data.fecha != null && data.empleado_id != null && this.nuevo == true // pinchando en dia de trabajador no tiene servicio
      ) {
          this.dialogocita = true;
        } else {
        axios.post("api/app/buscar-horario-disponible", data).then(function (res) {
          _this9.horas = _this9.filtrarHoras(res.data);

          _this9.$toast.sucs('consulta realizada');
        }, function (res) {});
      }
    },
    filtrarHoras: function filtrarHoras(lista_empleados) {
      var _this10 = this;

      // busca horas de trabajo utilizable por empleado
      this.local_horario = lista_empleados.map(function (element) {
        return {
          app_empleado_id: element.app_empleado_id,
          nombre_empleado: element.nombre_empleado,
          horario: _this10.filtrar_90_minutos(element.diferencia, _this10.evento.duracion)
        };
      });
    },
    filtrar_90_minutos: function filtrar_90_minutos(lista_horas, duracion) {
      // saca listado de horario disponible por empleado
      var lista = []; //Si tiene el filtro de horas activo aplica el filtro de los 30 minutos, si lo tiene desactivado no tendrá en cuenta los 30 minutos

      if (this.filtrohoras == true) {
        lista_horas.forEach(function (element, index, self_array) {
          var start = moment("2021-03-26 ".concat(element), 'YYYY-MM-DD HH:mm');

          var intervalos = _.range(duracion / 30 + 2).map(function (x) {
            return (x + 1) * 30;
          });

          var intervalos_completos = [-60, -30, 0].concat(_toConsumableArray(intervalos));
          var horas = intervalos_completos.map(function (x) {
            return start.clone().add(x, 'minutes').format('HH:mm');
          });
          var tiene_una_hora = self_array.includes(horas[0]) && self_array.includes(horas[1]);
          var no_tiene_nada = !self_array.includes(horas[1]);
          var tiene_una_hora_final = self_array.includes(horas[horas.length - 2]) && self_array.includes(horas[horas.length - 3]);
          var no_tiene_nada_final = !self_array.includes(horas[horas.length - 3]);

          var eliminar_inicio = _.drop(horas, 2);

          var intervalo_real = _.dropRight(eliminar_inicio, 3);

          var encaja = _.difference(intervalo_real, self_array).length === 0;

          if ((tiene_una_hora || no_tiene_nada) && (tiene_una_hora_final || no_tiene_nada_final) && encaja) {
            lista.push(element);
          }
        });
      } else {
        lista_horas.forEach(function (element, index, self_array) {
          var start = moment("2021-03-26 ".concat(element), 'YYYY-MM-DD HH:mm');

          var intervalos = _.range(duracion / 30 + 2).map(function (x) {
            return (x + 1) * 30;
          });

          var intervalos_completos = [-60, -30, 0].concat(_toConsumableArray(intervalos));
          var horas = intervalos_completos.map(function (x) {
            return start.clone().add(x, 'minutes').format('HH:mm');
          });

          var eliminar_inicio = _.drop(horas, 2);

          var intervalo_real = _.dropRight(eliminar_inicio, 3);

          var encaja = _.difference(intervalo_real, self_array).length === 0;

          if (encaja) {
            lista.push(element);
          }
        });
      }

      return lista;
    },
    asignarCita: function asignarCita(item, app_empleado_id) {
      // asigna los datos al pinchar en la hora (item) disponible para el empleado asignarDatos(item, empleado.app_empleado_id)                
      if (!this.editable) {
        this.evento.app_empleado_id = app_empleado_id;
      }

      this.evento.start = "".concat(this.evento.fecha, " ").concat(item);
      this.evento.end = moment(this.evento.start).clone().add(this.evento.duracion, 'minutes').format('YYYY-MM-DD HH:mm');
      this.evento.tipo = this.tipo;
      this.saveCita();
    },
    asignarDatos: function asignarDatos(item, empleado) {
      // Boton guardar cuando se selecciona la hora de la cita
      this.dataItem = item;
      this.dataIdemp = empleado;
      this.IdEmpleadoCita = empleado;
      this.evento.app_empleado_id = empleado;
      this.editable = false;
    },
    saveCita: function saveCita() {
      var _this11 = this;

      // graba cita con datos recibidos del metodo anterior asignarCita()
      //le paso las observaciones a evento para actualizarlo en el controller y grabamos la cita
      this.evento.observaciones = this.mascota.observaciones;
      this.evento.observacionesUsuario = this.usuario.observaciones;
      axios.post("api/app/savecita", this.evento).then(function (res) {
        var fecha = _this11.evento.fecha;

        _this11.$toast.sucs('cita guardada con exito');

        _this11.$emit('cita_guardada', res.data);

        _this11.closeDialog();

        _this11.$store.dispatch('getNotificaciones');

        axios.get("api/app/geteventsbymonth/".concat(fecha)).then(function (res) {
          _this11.citas = res.data;
        }, function (res) {});
      }, function (res) {
        if (res.response.status == 301) {
          return _this11.$toast.warn(res.response.data.message);
        }

        if (res.response.status == 422) {
          return _this11.$toast.warn('Debe completar los campos');
        }

        _this11.$toast.error('algo ha salido mal');
      });
    },
    getMascotas: function getMascotas(usuario_id, reseteo_mascota) {
      var _this12 = this;

      // Obtiene usuario id, mascota id , historial y evento  
      if (reseteo_mascota) {
        this.mascota = {
          historial: [],
          usuario: {
            observaciones: ''
          }
        };
      }

      axios.get("api/app/get-mascotas-by-user/".concat(usuario_id)).then(function (res) {
        _this12.mascotas = res.data;

        if (_this12.evento.app_mascota_id != null) {
          var i = _this12.mascotas.findIndex(function (x) {
            return x.id == _this12.evento.app_mascota_id;
          });

          _this12.mascota = _this12.mascotas[i];
        }
      }, function (res) {});
    },
    closeDialog: function closeDialog() {
      // Cierra formulario y resetea formulario
      this.filtrohoras = true;
      this.resetForm(); //this.dialog = false;
    },
    resetMascota: function resetMascota() {
      // resetea campos de inserccion de mascota
      this.tamanyo_selec = {
        id: null,
        nombre: null,
        peso: ""
      };
      this.local_mascota = {
        id: '',
        app_usuario_id: '',
        nombre: '',
        Fecha_Nacimiento: '',
        raza: '',
        sexo: '',
        tamanyo: '',
        pelo: '',
        peso: '',
        color: '',
        Adoptable: '',
        seccion_id: '',
        imagen: null,
        observaciones: '',
        codigo: '',
        imagen_path: null
      };
    },
    resetUsuario: function resetUsuario() {
      // resetea campos de inserccion de usuario
      this.usuario = {
        id: null,
        nombre: null,
        apellidos: null,
        email: null,
        telefono: null,
        codigo: null,
        observaciones: ''
      };
    },
    resetForm: function resetForm() {
      // resetea campos de formularios
      this.horas = [];
      this.local_horario = [];
      this.mascota = {
        historial: [],
        usuario: {
          observaciones: ''
        }
      };
      this.mascotas = [];
      this.dialog = false;
      this.evento = {
        app_empleado_id: null,
        app_usuario_id: null,
        app_mascota_id: null,
        app_tienda_id: this.app_tienda_id,
        color: null,
        start: null,
        end: null,
        duracion: null,
        servicios: [],
        fecha: null,
        observaciones: '',
        confirmada: 1,
        recogida: false,
        observacionesMascota: '',
        observacionesUsuario: '',
        direccion_recogida: null,
        direccion_entrega: null,
        pago: 0,
        precio: ''
      };
      this.editable = false;
      this.IdEmpleadoCita = this.idEmpFormulario;
      this.dataItem = '';
      this.evento_nuevo = true;
      this.tamanyo_selec = {
        id: null,
        nombre: null,
        peso: ""
      };
      this.resetUsuario();
    },
    eliminarCita: function eliminarCita(toggle_exclusive) {
      var _this13 = this;

      // Elimina cita en pantalla
      axios.get("api/app/eliminarcita/".concat(this.evento.id, "/").concat(toggle_exclusive)).then(function (res) {
        _this13.$emit('eliminar_cita', _this13.evento, toggle_exclusive);

        _this13.closeDialog();
      }, function (res) {
        _this13.$toast.error('algo ha salido mal');
      });
      this.toggle_exclusive = null;
    },
    cierraeliminar: function cierraeliminar() {
      // Cierra formulario y resetea formulario
      this.toggle_exclusive = null;
      this.dialogocancelar = false;
    },
    cierraobligacita: function cierraobligacita() {
      // Cierra aviso obligado de cita
      this.dialogocita = false;
    },
    cierrabusqueda: function cierrabusqueda() {
      // Cierra busqueda
      this.resetForm();
      this.citapet = {};
      this.citacli = {};
      this.dialogobuscar = false;
    },
    abrirbusqueda: function abrirbusqueda() {
      // Abre busqueda
      this.citapet = {};
      this.citacli = {};
      this.dialogobuscar = true;
    },
    busqueda: function busqueda(id) {
      var _this14 = this;

      // Busqueda
      this.citacli = {};
      console.log("clientes");
      console.log(id);
      axios.get("api/app/getcitasbyuser/".concat(id)).then(function (res) {
        console.log("citas clientes");
        console.log(res.data);
        res.data.cita.forEach(function (cita) {
          _this14.citacli = cita;
        });
      }, function (err) {});
    },
    citaPet: function citaPet(citacli) {
      console.log("redirigiiiir");
      console.log(citacli);
      var base_url = citacli.tipo == 'peluqueria' ? 'citas-peluqueria?tipo=peluqueria' : 'citas-clinica?tipo=clinica';
      this.$router.push("".concat(base_url, "&fecha=").concat(citacli.start_format, "&tienda=").concat(citacli.tienda))["catch"](function () {});
      this.cierrabusqueda();
    }
  },
  computed: {
    filtrar_horas_reales: function filtrar_horas_reales() {
      return [];
    },
    evento_horario: function evento_horario() {
      return [];
    },
    historial: function historial() {
      if (this.mascota.historial.length > 0) {
        return this.mascota.historial.map(function (x) {
          return x.servicio;
        });
      }

      return null;
    },
    isloading: function isloading() {
      return this.$store.getters.getloading;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ref--5-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--5-2!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.i, "\n.dia-header {\n    padding: 1px 1rem;\n    text-align: center;\n    border-left: #e0e0e0 0.5px solid;\n    border-bottom: #e0e0e0 0.5px solid;\n    border-top: #e0e0e0 0.5px solid;\n}\n.full-width {\n    width: 100% !important;\n}\n.dia-header span {\n    display: block;\n}\n.dia-container {\n    display: flex;\n}\n.dia-component {\n    min-width: 132px;\n}\n.cita-container {\n    display: flex;\n    width: 100%;\n}\n.calendar-wrapper {\n    overflow: hidden;\n    overflow-x: auto;\n    overflow-y: scroll;\n    display: flex;\n}\n.false_scroll {\n    height: 20px;\n    overflow-x: auto;\n}\n.false_scroll_container {\n    width: 3500px !important;\n    height: 10px;\n    overflow-x: auto;\n    display: flex;\n}\n@media (min-width:1900px) {\n.empleado-row{\n        height: 26px !important;\n        width: 100% !important;\n        padding-left: 5px;\n        margin-right: 3px;\n        font-size: 12px !important;\n}\n.empleado-column {\n        width: inherit;\n        min-height: auto;\n        position: relative !important;\n}\n.cita-element{\n        width: 99%;\n        padding-left: 5px;\n        margin-right: 2px;\n        font-size: 12px !important;\n        overflow: hidden !important;\n}\n.dia-header{\n        height: 60px !important;\n}\nbutton#diabtn.v-btn{\n        height: 50% !important;\n}\n#historial span {\n        font-size: 9px !important;\n}\n}\n", ""]);
// Exports
/* harmony default export */ __webpack_exports__["default"] = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ref--5-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--5-2!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.i, "\n.hide-column {\n    display: none !important;\n}\n.empleado-nombre {\n    width: 100%;\n    padding: 0.1rem;\n    text-align: center;\n    text-transform: uppercase;\n    font-size: 4px;\n}\n.empleado-column {\n    min-height: 100vh;\n    position: relative;\n}\n.week {\n    /*width: 100px;*/\n    width: inherit;\n}\n.day {\n    width: inherit;\n}\n.empleado-row {\n    border-right: #e0e0e0 1px solid;\n    border-bottom: #e0e0e0 1px solid;\n    height: 40px;\n    width: auto;\n    font-size: 12px;\n}\n.empleado-row1 {\n    border-right: #e0e0e0 1px solid;\n    border-bottom: #e0e0e0 1px solid;\n    height: 90px;\n    width: 292px;\n    font-size: 19px;\n}\n.disabled-row {\n    background-color: #485772;\n    color: #ffffff !important;\n}\n.cita-element {\n    position: absolute;\n    left: 0px;\n    width: 99%;\n    background-color: #1e5dbf;\n    border-radius: 8px;\n    border: solid 1px #fff;\n    padding: 3px;\n    color: #fff;\n    font-size: 12px;\n}\n", ""]);
// Exports
/* harmony default export */ __webpack_exports__["default"] = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ref--5-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--5-2!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.i, "\n.cita-element {\n    background-color: #1e5dbf;\n    border-radius: 8px;\n    font-size: 10px !important; \n    padding: 3px;\n    color: #fff;        \n    overflow: hidden;\n}\ndiv#buscar.cita-element i{\n    color: #fff;\n    font-size: 15px !important; \n    text-transform: uppercase !important;\n}\n.cita :hover{\n    cursor: pointer;\n}    \n", ""]);
// Exports
/* harmony default export */ __webpack_exports__["default"] = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??ref--5-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--5-2!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Cita_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/css-loader/dist/cjs.js??ref--5-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--5-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Cita.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=style&index=0&media=screen&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Cita_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ __webpack_exports__["default"] = (_node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Cita_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??ref--5-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--5-2!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_empleadoComponent_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/css-loader/dist/cjs.js??ref--5-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--5-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_empleadoComponent_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ __webpack_exports__["default"] = (_node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_empleadoComponent_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??ref--5-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--5-2!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_eventoComponent_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/css-loader/dist/cjs.js??ref--5-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--5-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_eventoComponent_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ __webpack_exports__["default"] = (_node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_eventoComponent_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=template&id=52af0b6d&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=template&id=52af0b6d& ***!
  \*****************************************************************************************************************************************************************************************************************/
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
    "div",
    {},
    [
      _vm.overlay
        ? _c(
            "v-overlay",
            [
              _c(
                "v-progress-circular",
                {
                  attrs: {
                    indeterminate: "",
                    size: "220",
                    color: "green",
                    width: "10"
                  }
                },
                [
                  _c("v-col", [
                    _c(
                      "strong",
                      { staticStyle: { color: "white !important" } },
                      [_vm._v(" Cargando datos")]
                    )
                  ])
                ],
                1
              )
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _c(
        "v-row",
        [
          _c(
            "v-col",
            { attrs: { cols: "12", md: "3" } },
            [
              _c("v-autocomplete", {
                attrs: {
                  items: _vm.tiendas,
                  "item-text": "nombre",
                  "item-value": "id",
                  dense: "",
                  outlined: "",
                  "hide-details": "",
                  label: "Tienda"
                },
                model: {
                  value: _vm.tienda,
                  callback: function($$v) {
                    _vm.tienda = $$v
                  },
                  expression: "tienda"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _vm.tienda
            ? _c(
                "v-col",
                { attrs: { cols: "12", md: "3" } },
                [
                  _vm._l(_vm.calendar_types, function(tipo) {
                    return _c(
                      "v-btn",
                      {
                        key: tipo.value,
                        staticClass: "mr-2",
                        class: tipo.value == _vm.type ? "pink white--text" : "",
                        attrs: { rounded: "", depressed: "" },
                        on: {
                          click: function($event) {
                            return _vm.semana()
                          }
                        }
                      },
                      [_vm._v(_vm._s(tipo.text) + "\n            ")]
                    )
                  }),
                  _vm._v(" "),
                  _c(
                    "v-btn",
                    {
                      staticClass: "white--text mr-2",
                      attrs: { rounded: "", depressed: "", color: "green" },
                      on: {
                        click: function($event) {
                          return _vm.$emit("open_dialog")
                        }
                      }
                    },
                    [_vm._v("Nuevo")]
                  ),
                  _vm._v(" "),
                  _vm.tienda
                    ? _c(
                        "v-btn",
                        {
                          staticClass: "white--text mr-2",
                          attrs: { rounded: "", depressed: "", color: "blue" },
                          on: {
                            click: function($event) {
                              return _vm.$emit("abrirbusqueda")
                            }
                          }
                        },
                        [_vm._v("Buscar cita")]
                      )
                    : _vm._e()
                ],
                2
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.tienda
            ? _c(
                "v-col",
                { attrs: { cols: "12", md: "5" } },
                [
                  _c(
                    "v-btn",
                    {
                      staticClass: "mr-4",
                      attrs: { outlined: "", color: "grey darken-2" },
                      on: { click: _vm.setToday }
                    },
                    [_vm._v("Hoy")]
                  ),
                  _vm._v(" "),
                  _c(
                    "v-btn",
                    {
                      attrs: {
                        fab: "",
                        text: "",
                        small: "",
                        color: "grey darken-2"
                      },
                      on: { click: _vm.prev }
                    },
                    [
                      _c("v-icon", { attrs: { small: "" } }, [
                        _vm._v("mdi-chevron-left")
                      ])
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-btn",
                    {
                      attrs: {
                        fab: "",
                        text: "",
                        small: "",
                        color: "grey darken-2"
                      },
                      on: { click: _vm.next }
                    },
                    [
                      _c("v-icon", { attrs: { small: "" } }, [
                        _vm._v("mdi-chevron-right")
                      ])
                    ],
                    1
                  )
                ],
                1
              )
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _vm.tienda
        ? _c("v-col", { attrs: { cols: "12" } }, [
            _c(
              "div",
              {
                ref: "false_scroll",
                staticClass: "false_scroll",
                on: {
                  scroll: function($event) {
                    if (
                      !$event.type.indexOf("key") &&
                      _vm._k(
                        $event.keyCode,
                        "pasive",
                        undefined,
                        $event.key,
                        undefined
                      )
                    ) {
                      return null
                    }
                    return _vm.falseScrollFunction.apply(null, arguments)
                  }
                }
              },
              [_c("div", { staticClass: "false_scroll_container" })]
            )
          ])
        : _vm._e(),
      _vm._v(" "),
      _vm.tienda
        ? _c("v-col", { attrs: { cols: "12" } }, [
            _c(
              "div",
              {
                ref: "calnedar_wrap",
                staticClass: "calendar-wrapper",
                on: {
                  scroll: function($event) {
                    if (
                      !$event.type.indexOf("key") &&
                      _vm._k(
                        $event.keyCode,
                        "pasive",
                        undefined,
                        $event.key,
                        undefined
                      )
                    ) {
                      return null
                    }
                    return _vm.scrollFunction.apply(null, arguments)
                  }
                }
              },
              [
                _c(
                  "div",
                  {
                    staticClass: "dia-container",
                    class: { "full-width": _vm.type == "day" }
                  },
                  _vm._l(_vm.set_week_days, function(weekday, i) {
                    return _c(
                      "div",
                      {
                        staticClass: "dia-component",
                        class: { "full-width": _vm.type == "day" }
                      },
                      [
                        _c(
                          "div",
                          { staticClass: "dia-header" },
                          [
                            _c("span", [
                              _vm._v(" " + _vm._s(weekday.nombre_dia))
                            ]),
                            _vm._v(" "),
                            _c(
                              "v-btn",
                              {
                                class: {
                                  "green white--text":
                                    weekday.full_date ==
                                    _vm.current_day_inmutable
                                },
                                attrs: { id: "diabtn" },
                                on: {
                                  click: function($event) {
                                    return _vm.selectDay(weekday)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                            " +
                                    _vm._s(weekday.numero_dia) +
                                    "\n                        "
                                )
                              ]
                            )
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "cita-container mt-2" },
                          _vm._l(_vm.empleados, function(empleado) {
                            return _c("empleado-component", {
                              key: empleado.id,
                              attrs: {
                                intervalos: _vm.intervalos,
                                app_tienda_id: _vm.tienda,
                                empleado: empleado,
                                citas: _vm.getCitas(
                                  empleado,
                                  weekday.full_date
                                ),
                                horario: _vm.getHorario(
                                  empleado,
                                  weekday.full_date
                                ),
                                fechas: _vm.getFechas(
                                  empleado,
                                  weekday.full_date
                                ),
                                dia_actual: weekday.full_date,
                                interval_height: _vm.slider,
                                type: _vm.type
                              }
                            })
                          }),
                          1
                        )
                      ]
                    )
                  }),
                  0
                )
              ]
            )
          ])
        : _vm._e(),
      _vm._v(" "),
      _c(
        "v-col",
        { attrs: { cols: "12", md: "3" } },
        [
          _c("evento-component", {
            attrs: {
              tipo: _vm.tipo,
              app_tienda_id: _vm.tienda,
              isloading: _vm.isloading,
              abrirbusqueda: _vm.abrirbusqueda(),
              empleados: _vm.empleados,
              clientes: _vm.clientes,
              servicios: _vm.servicios
            },
            on: {
              eliminar_cita: _vm.deleteCita,
              cita_guardada: _vm.agregarCita,
              resetClientes: _vm.resetClientes
            }
          })
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=template&id=3f205c68&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=template&id=3f205c68& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
    "div",
    {
      staticClass: "empleado-column",
      class: [
        _vm.type == "week" ? "week" : "day",
        { "hide-column": !_vm.horario }
      ]
    },
    [
      _c(
        "div",
        { staticClass: "empleado-nombre" },
        [
          _c(
            "v-chip",
            {
              staticClass: "white--text",
              attrs: {
                color: _vm.empleado.color,
                to: { path: "/guardar-empleado-app?id=" + _vm.empleado.id },
                small: ""
              }
            },
            [_vm._v("\n         " + _vm._s(_vm.empleado.nombre) + " ")]
          )
        ],
        1
      ),
      _vm._v(" "),
      _vm._l(_vm.intervalos, function(intervalo, i) {
        return _vm.horario &&
          _vm.empleadoHorario(
            _vm.empleado.nombre + "_" + _vm.dia_actual + "_" + intervalo
          )
          ? _c(
              "div",
              {
                ref:
                  _vm.empleado.nombre + "_" + _vm.dia_actual + "_" + intervalo,
                refInFor: true,
                staticClass: "empleado-row",
                style: { height: _vm.interval_height + "px" },
                on: {
                  click: function($event) {
                    return _vm.openForm()
                  }
                }
              },
              [_vm._v(" \n        " + _vm._s(intervalo) + "\n    ")]
            )
          : _c(
              "div",
              {
                staticClass: "empleado-row disabled-row",
                style: { height: _vm.interval_height + "px" }
              },
              [_vm._v(_vm._s(intervalo) + " ")]
            )
      }),
      _vm._v(" "),
      _vm._l(_vm.local_citas, function(cita) {
        return _c(
          "div",
          {
            key: cita.id,
            staticClass: "cita-element",
            style: [_vm.timeToY(cita)],
            on: {
              click: function($event) {
                return _vm.setCita(cita)
              }
            }
          },
          [
            !cita.confirmada
              ? _c("v-icon", { attrs: { small: "", color: "white" } }, [
                  _vm._v("mdi-alert-circle")
                ])
              : _vm._e(),
            _vm._v(" "),
            _c("i", { staticStyle: { "text-transform": "capitalize" } }, [
              _vm._v(_vm._s(cita.usuario) + " - " + _vm._s(cita.telefono))
            ])
          ],
          1
        )
      })
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=template&id=5867c3de&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=template&id=5867c3de& ***!
  \****************************************************************************************************************************************************************************************************************************/
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
      _vm.overlay
        ? _c(
            "v-overlay",
            [
              _c(
                "v-progress-circular",
                {
                  attrs: {
                    indeterminate: "",
                    size: "220",
                    color: "green",
                    width: "10"
                  }
                },
                [
                  _c("v-col", [
                    _c(
                      "strong",
                      { staticStyle: { color: "white !important" } },
                      [_vm._v(" Cargando datos")]
                    )
                  ])
                ],
                1
              )
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _c(
        "v-dialog",
        {
          attrs: { persistent: "", width: "600" },
          model: {
            value: _vm.dialogobuscar,
            callback: function($$v) {
              _vm.dialogobuscar = $$v
            },
            expression: "dialogobuscar"
          }
        },
        [
          [
            _c(
              "v-card",
              [
                _c(
                  "v-card-title",
                  {
                    staticClass: "headline green white--text",
                    attrs: { dark: "", "primary-title": "" }
                  },
                  [_vm._v("Buscar Cita Cliente")]
                ),
                _vm._v(" "),
                _c(
                  "v-card-text",
                  { staticClass: "px-3 py-3" },
                  [
                    _vm.isloading ? _c("loader") : _vm._e(),
                    _vm._v(" "),
                    _c(
                      "v-row",
                      [
                        _c("v-autocomplete", {
                          staticClass: "col-6",
                          attrs: {
                            label: "Cliente",
                            items: _vm.clientes,
                            "item-text": _vm.getItemText,
                            "item-value": "id"
                          },
                          model: {
                            value: _vm.evento.app_usuario_id,
                            callback: function($$v) {
                              _vm.$set(_vm.evento, "app_usuario_id", $$v)
                            },
                            expression: "evento.app_usuario_id"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("strong", [
                      _c("p", { staticClass: "ml-4 my-0 pa-0" }, [
                        _vm._v("Citas cliente")
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "v-row",
                      { staticClass: "mb-4" },
                      [
                        _vm.citacli.id == null
                          ? _c(
                              "v-col",
                              {
                                staticClass: "mt-2 mb-0",
                                attrs: { align: "center", justify: "center" }
                              },
                              [
                                _c("strong", [
                                  _c("p", [
                                    _vm._v(
                                      "No Existen citas para el cliente seleccionado"
                                    )
                                  ])
                                ])
                              ]
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _vm.citacli.id != null
                          ? _c(
                              "v-row",
                              {
                                staticClass: "cita mt-2 mb-4",
                                attrs: {
                                  id: "buscarcita",
                                  justify: "space-around"
                                }
                              },
                              [
                                _c(
                                  "v-col",
                                  {
                                    staticClass: "cita-element mb-4",
                                    attrs: {
                                      id: "buscar",
                                      align: "center",
                                      justify: "center"
                                    },
                                    on: {
                                      click: function($event) {
                                        return _vm.citaPet(_vm.citacli)
                                      }
                                    }
                                  },
                                  [
                                    _c(
                                      "v-row",
                                      { attrs: { justify: "center" } },
                                      [
                                        _c("i", [
                                          _vm._v(
                                            "Fecha: " +
                                              _vm._s(_vm.citacli.start) +
                                              " - " +
                                              _vm._s(_vm.citacli.tienda)
                                          )
                                        ])
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "v-row",
                                      { attrs: { justify: "center" } },
                                      [
                                        _c("i", [
                                          _vm._v(
                                            "Servicio: " +
                                              _vm._s(_vm.citacli.servicios) +
                                              " - Empleado: " +
                                              _vm._s(_vm.citacli.empleado)
                                          )
                                        ])
                                      ]
                                    )
                                  ],
                                  1
                                )
                              ],
                              1
                            )
                          : _vm._e()
                      ],
                      1
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "v-row",
                  {
                    staticClass: "pa-4 ma-4",
                    attrs: { align: "center", justify: "center" }
                  },
                  [
                    _c(
                      "v-btn",
                      {
                        staticClass: "white--text mx-1 mt-4 mb-0",
                        attrs: {
                          small: "",
                          md: "3",
                          rounded: "",
                          depressed: "",
                          color: "success"
                        },
                        on: {
                          click: function($event) {
                            return _vm.busqueda(_vm.evento.app_usuario_id)
                          }
                        }
                      },
                      [_vm._v("Buscar")]
                    ),
                    _vm._v(" "),
                    _c(
                      "v-btn",
                      {
                        staticClass: "white--text mx-1 mt-4 mb-0",
                        attrs: {
                          small: "",
                          md: "3",
                          rounded: "",
                          depressed: "",
                          color: "red"
                        },
                        on: {
                          click: function($event) {
                            return _vm.cierrabusqueda()
                          }
                        }
                      },
                      [_vm._v("Cerrar")]
                    )
                  ],
                  1
                )
              ],
              1
            )
          ]
        ],
        2
      ),
      _vm._v(" "),
      _c(
        "v-dialog",
        {
          attrs: { persistent: "" },
          on: {
            keydown: function($event) {
              if (
                !$event.type.indexOf("key") &&
                _vm._k($event.keyCode, "esc", 27, $event.key, ["Esc", "Escape"])
              ) {
                return null
              }
              return _vm.closeDialog.apply(null, arguments)
            },
            "click:outside": _vm.closeDialog
          },
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
              _c(
                "v-card-title",
                {
                  staticClass: "headline green white--text",
                  attrs: { dark: "", "primary-title": "" }
                },
                [_vm._v("Guardar / Editar Cita - " + _vm._s(_vm.tipo))]
              ),
              _vm._v(" "),
              _c(
                "v-card-text",
                { staticClass: "px-3 py-3" },
                [
                  _vm.isloading ? _c("loader") : _vm._e(),
                  _vm._v(" "),
                  _c(
                    "v-card",
                    { staticClass: "pl-5", attrs: { outlined: "" } },
                    [
                      _c("v-card-title", [_vm._v("Datos Cliente")]),
                      _vm._v(" "),
                      _c(
                        "v-row",
                        { staticClass: "pa-1 ma-1", attrs: { dense: "" } },
                        [
                          _c(
                            "v-col",
                            {
                              staticClass: "px-2 pt-0 mt-0",
                              attrs: { cols: "12", md: "2" }
                            },
                            [
                              _c("v-autocomplete", {
                                attrs: {
                                  label: "Empleado",
                                  items: _vm.local_empleados,
                                  "item-text": "nombre",
                                  "item-value": "id"
                                },
                                on: {
                                  change: function($event) {
                                    return _vm.buscarDisponible()
                                  }
                                },
                                model: {
                                  value: _vm.evento.app_empleado_id,
                                  callback: function($$v) {
                                    _vm.$set(_vm.evento, "app_empleado_id", $$v)
                                  },
                                  expression: "evento.app_empleado_id"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "v-col",
                            {
                              staticClass: "px-2 pt-0 mt-0",
                              attrs: { cols: "12", md: "6" }
                            },
                            [
                              _c(
                                "v-row",
                                [
                                  !_vm.usuario.telefono
                                    ? _c("v-autocomplete", {
                                        staticClass: "col-10",
                                        attrs: {
                                          label: "Cliente",
                                          items: _vm.clientes,
                                          hint: "",
                                          "persistent-hint": "",
                                          "item-text": _vm.getItemText,
                                          "return-object": "",
                                          "item-value": "id"
                                        },
                                        model: {
                                          value: _vm.usuario,
                                          callback: function($$v) {
                                            _vm.usuario = $$v
                                          },
                                          expression: "usuario"
                                        }
                                      })
                                    : _c("v-autocomplete", {
                                        staticClass: "col-10",
                                        attrs: {
                                          label: "Cliente",
                                          items: _vm.clientes,
                                          hint: "" + _vm.usuario.telefono,
                                          "persistent-hint": "",
                                          "item-text": _vm.getItemText,
                                          "return-object": "",
                                          "item-value": "id"
                                        },
                                        model: {
                                          value: _vm.usuario,
                                          callback: function($$v) {
                                            _vm.usuario = $$v
                                          },
                                          expression: "usuario"
                                        }
                                      }),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    {
                                      staticClass: "text-center pa-0 mt-3 ma-0"
                                    },
                                    [
                                      _c(
                                        "v-dialog",
                                        {
                                          attrs: { width: "900" },
                                          scopedSlots: _vm._u([
                                            {
                                              key: "activator",
                                              fn: function(ref) {
                                                var on = ref.on
                                                var attrs = ref.attrs
                                                return [
                                                  _c(
                                                    "v-btn",
                                                    _vm._g(
                                                      _vm._b(
                                                        {
                                                          staticClass:
                                                            "mr-1 mt-4",
                                                          attrs: {
                                                            "x-small": "",
                                                            color: "success",
                                                            rounded: "",
                                                            depressed: "",
                                                            dark: ""
                                                          },
                                                          on: {
                                                            click: function(
                                                              $event
                                                            ) {
                                                              return _vm.editCostumer(
                                                                "nuevo"
                                                              )
                                                            }
                                                          }
                                                        },
                                                        "v-btn",
                                                        attrs,
                                                        false
                                                      ),
                                                      on
                                                    ),
                                                    [
                                                      _c(
                                                        "v-icon",
                                                        { attrs: { dark: "" } },
                                                        [_vm._v("mdi-plus")]
                                                      )
                                                    ],
                                                    1
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "v-btn",
                                                    _vm._g(
                                                      _vm._b(
                                                        {
                                                          staticClass:
                                                            "mt-4 mr-1",
                                                          attrs: {
                                                            disabled: !_vm
                                                              .evento
                                                              .app_usuario_id,
                                                            "x-small": "",
                                                            color: "green",
                                                            rounded: "",
                                                            depressed: "",
                                                            dark: ""
                                                          },
                                                          on: {
                                                            click: function(
                                                              $event
                                                            ) {
                                                              return _vm.editCostumer(
                                                                "editar"
                                                              )
                                                            }
                                                          }
                                                        },
                                                        "v-btn",
                                                        attrs,
                                                        false
                                                      ),
                                                      on
                                                    ),
                                                    [
                                                      _c(
                                                        "v-icon",
                                                        { attrs: { dark: "" } },
                                                        [
                                                          _vm._v(
                                                            "mdi-account-edit"
                                                          )
                                                        ]
                                                      )
                                                    ],
                                                    1
                                                  )
                                                ]
                                              }
                                            }
                                          ]),
                                          model: {
                                            value: _vm.dialogo,
                                            callback: function($$v) {
                                              _vm.dialogo = $$v
                                            },
                                            expression: "dialogo"
                                          }
                                        },
                                        [
                                          _vm._v(" "),
                                          _c(
                                            "v-card",
                                            [
                                              _c(
                                                "v-card-title",
                                                {
                                                  staticClass:
                                                    "text-h5 green white--text"
                                                },
                                                [
                                                  _vm._v(
                                                    "Agregar Nuevo cliente"
                                                  )
                                                ]
                                              ),
                                              _vm._v(" "),
                                              _c(
                                                "v-card-text",
                                                [
                                                  _c(
                                                    "v-container",
                                                    { staticClass: "mb-0" },
                                                    [
                                                      _vm.isloading
                                                        ? _c("loader")
                                                        : _vm._e(),
                                                      _vm._v(" "),
                                                      _c(
                                                        "v-row",
                                                        [
                                                          _c(
                                                            "v-col",
                                                            [
                                                              _c(
                                                                "v-row",
                                                                {
                                                                  attrs: {
                                                                    dense: ""
                                                                  }
                                                                },
                                                                [
                                                                  _c(
                                                                    "v-col",
                                                                    {
                                                                      attrs: {
                                                                        cols:
                                                                          "12",
                                                                        md: "6"
                                                                      }
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "v-text-field",
                                                                        {
                                                                          attrs: {
                                                                            filled:
                                                                              "",
                                                                            label:
                                                                              "Nombre",
                                                                            required:
                                                                              ""
                                                                          },
                                                                          model: {
                                                                            value:
                                                                              _vm
                                                                                .usuarioEdit
                                                                                .nombre,
                                                                            callback: function(
                                                                              $$v
                                                                            ) {
                                                                              _vm.$set(
                                                                                _vm.usuarioEdit,
                                                                                "nombre",
                                                                                $$v
                                                                              )
                                                                            },
                                                                            expression:
                                                                              "usuarioEdit.nombre"
                                                                          }
                                                                        }
                                                                      )
                                                                    ],
                                                                    1
                                                                  ),
                                                                  _vm._v(" "),
                                                                  _c(
                                                                    "v-col",
                                                                    {
                                                                      attrs: {
                                                                        cols:
                                                                          "12",
                                                                        md: "6"
                                                                      }
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "v-text-field",
                                                                        {
                                                                          attrs: {
                                                                            filled:
                                                                              "",
                                                                            label:
                                                                              "Apellidos",
                                                                            required:
                                                                              ""
                                                                          },
                                                                          model: {
                                                                            value:
                                                                              _vm
                                                                                .usuarioEdit
                                                                                .apellidos,
                                                                            callback: function(
                                                                              $$v
                                                                            ) {
                                                                              _vm.$set(
                                                                                _vm.usuarioEdit,
                                                                                "apellidos",
                                                                                $$v
                                                                              )
                                                                            },
                                                                            expression:
                                                                              "usuarioEdit.apellidos"
                                                                          }
                                                                        }
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
                                                                {
                                                                  attrs: {
                                                                    dense: ""
                                                                  }
                                                                },
                                                                [
                                                                  _c(
                                                                    "v-col",
                                                                    {
                                                                      attrs: {
                                                                        cols:
                                                                          "12",
                                                                        md: "6"
                                                                      }
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "v-text-field",
                                                                        {
                                                                          attrs: {
                                                                            filled:
                                                                              "",
                                                                            label:
                                                                              "Email",
                                                                            required:
                                                                              ""
                                                                          },
                                                                          model: {
                                                                            value:
                                                                              _vm
                                                                                .usuarioEdit
                                                                                .email,
                                                                            callback: function(
                                                                              $$v
                                                                            ) {
                                                                              _vm.$set(
                                                                                _vm.usuarioEdit,
                                                                                "email",
                                                                                $$v
                                                                              )
                                                                            },
                                                                            expression:
                                                                              "usuarioEdit.email"
                                                                          }
                                                                        }
                                                                      )
                                                                    ],
                                                                    1
                                                                  ),
                                                                  _vm._v(" "),
                                                                  _c(
                                                                    "v-col",
                                                                    {
                                                                      attrs: {
                                                                        cols:
                                                                          "12",
                                                                        md: "6"
                                                                      }
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "v-text-field",
                                                                        {
                                                                          attrs: {
                                                                            filled:
                                                                              "",
                                                                            label:
                                                                              "teléfono",
                                                                            required:
                                                                              ""
                                                                          },
                                                                          model: {
                                                                            value:
                                                                              _vm
                                                                                .usuarioEdit
                                                                                .telefono,
                                                                            callback: function(
                                                                              $$v
                                                                            ) {
                                                                              _vm.$set(
                                                                                _vm.usuarioEdit,
                                                                                "telefono",
                                                                                $$v
                                                                              )
                                                                            },
                                                                            expression:
                                                                              "usuarioEdit.telefono"
                                                                          }
                                                                        }
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
                                                                {
                                                                  attrs: {
                                                                    dense: ""
                                                                  }
                                                                },
                                                                [
                                                                  _c(
                                                                    "v-col",
                                                                    {
                                                                      attrs: {
                                                                        cols:
                                                                          "12",
                                                                        md: "12"
                                                                      }
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "v-textarea",
                                                                        {
                                                                          attrs: {
                                                                            filled:
                                                                              "",
                                                                            label:
                                                                              "Observaciones"
                                                                          },
                                                                          model: {
                                                                            value:
                                                                              _vm
                                                                                .usuarioEdit
                                                                                .observaciones,
                                                                            callback: function(
                                                                              $$v
                                                                            ) {
                                                                              _vm.$set(
                                                                                _vm.usuarioEdit,
                                                                                "observaciones",
                                                                                $$v
                                                                              )
                                                                            },
                                                                            expression:
                                                                              "usuarioEdit.observaciones"
                                                                          }
                                                                        }
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
                                                                {
                                                                  attrs: {
                                                                    dense: ""
                                                                  }
                                                                },
                                                                [
                                                                  _c(
                                                                    "v-col",
                                                                    {
                                                                      attrs: {
                                                                        cols:
                                                                          "12"
                                                                      }
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "v-btn",
                                                                        {
                                                                          staticClass:
                                                                            "white--text",
                                                                          attrs: {
                                                                            disabled:
                                                                              _vm.isloading,
                                                                            rounded:
                                                                              "",
                                                                            depressed:
                                                                              "",
                                                                            color:
                                                                              "success"
                                                                          },
                                                                          on: {
                                                                            click:
                                                                              _vm.saveUsuario
                                                                          }
                                                                        },
                                                                        [
                                                                          _vm._v(
                                                                            "Guardar"
                                                                          )
                                                                        ]
                                                                      ),
                                                                      _vm._v(
                                                                        " "
                                                                      ),
                                                                      _c(
                                                                        "v-btn",
                                                                        {
                                                                          staticClass:
                                                                            "red",
                                                                          attrs: {
                                                                            disabled:
                                                                              _vm.isloading,
                                                                            rounded:
                                                                              "",
                                                                            depressed:
                                                                              "",
                                                                            color:
                                                                              "danger",
                                                                            dark:
                                                                              ""
                                                                          },
                                                                          on: {
                                                                            click: function(
                                                                              $event
                                                                            ) {
                                                                              _vm.dialogo = false
                                                                            }
                                                                          }
                                                                        },
                                                                        [
                                                                          _vm._v(
                                                                            "Salir"
                                                                          )
                                                                        ]
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
                            {
                              staticClass: "px-2 pt-0 mt-0",
                              attrs: { cols: "12", md: "2" }
                            },
                            [
                              _c("v-text-field", {
                                attrs: {
                                  label: "Precio",
                                  required: "",
                                  type: "number"
                                },
                                model: {
                                  value: _vm.evento.precio,
                                  callback: function($$v) {
                                    _vm.$set(_vm.evento, "precio", $$v)
                                  },
                                  expression: "evento.precio"
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
                        { staticClass: "pr-4 ma-1", attrs: { dense: "" } },
                        [
                          _c("v-textarea", {
                            attrs: {
                              outlined: "",
                              height: "50px",
                              label: "Observaciones Usuario"
                            },
                            model: {
                              value: _vm.usuario.observaciones,
                              callback: function($$v) {
                                _vm.$set(_vm.usuario, "observaciones", $$v)
                              },
                              expression: "usuario.observaciones"
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
                    "v-card",
                    {
                      staticClass: "pl-5",
                      staticStyle: { "margin-top": "2px" },
                      attrs: { outlined: "" }
                    },
                    [
                      _c("v-card-title", [_vm._v("Datos Servicios")]),
                      _vm._v(" "),
                      _c(
                        "v-row",
                        { staticClass: "pa-0 ma-1", attrs: { dense: "" } },
                        [
                          _c(
                            "v-col",
                            {
                              staticClass: "px-3 mb-0",
                              attrs: { cols: "12", md: "12" }
                            },
                            [
                              _c("v-autocomplete", {
                                attrs: {
                                  label: "Servicios",
                                  "return-object": "",
                                  items: _vm.servicios,
                                  "item-text": "nombre",
                                  "item-value": "id",
                                  "menu-props": { maxHeight: "300" },
                                  multiple: ""
                                },
                                on: {
                                  change: function($event) {
                                    return _vm.buscarDisponible()
                                  }
                                },
                                scopedSlots: _vm._u([
                                  {
                                    key: "selection",
                                    fn: function(ref) {
                                      var item = ref.item
                                      var index = ref.index
                                      return [
                                        _c(
                                          "v-chip-group",
                                          [
                                            index === 0
                                              ? _c(
                                                  "v-chip",
                                                  {
                                                    staticClass: "white--text",
                                                    attrs: {
                                                      color: "orange",
                                                      small: ""
                                                    }
                                                  },
                                                  [
                                                    _c("span", [
                                                      _vm._v(
                                                        _vm._s(item.nombre)
                                                      )
                                                    ])
                                                  ]
                                                )
                                              : _vm._e(),
                                            _vm._v(" "),
                                            index === 1
                                              ? _c(
                                                  "v-chip",
                                                  {
                                                    staticClass: "white--text",
                                                    attrs: {
                                                      color: "orange",
                                                      small: ""
                                                    }
                                                  },
                                                  [
                                                    _c("span", [
                                                      _vm._v(
                                                        _vm._s(item.nombre)
                                                      )
                                                    ])
                                                  ]
                                                )
                                              : _vm._e(),
                                            _vm._v(" "),
                                            index === 2
                                              ? _c(
                                                  "v-chip",
                                                  {
                                                    staticClass: "white--text",
                                                    attrs: {
                                                      color: "orange",
                                                      small: ""
                                                    }
                                                  },
                                                  [
                                                    _c("span", [
                                                      _vm._v(
                                                        _vm._s(item.nombre)
                                                      )
                                                    ])
                                                  ]
                                                )
                                              : _vm._e(),
                                            _vm._v(" "),
                                            index === 3
                                              ? _c(
                                                  "v-chip",
                                                  {
                                                    staticClass: "white--text",
                                                    attrs: {
                                                      color: "orange",
                                                      small: ""
                                                    }
                                                  },
                                                  [
                                                    _c("span", [
                                                      _vm._v(
                                                        _vm._s(item.nombre)
                                                      )
                                                    ])
                                                  ]
                                                )
                                              : _vm._e(),
                                            _vm._v(" "),
                                            index === 4
                                              ? _c(
                                                  "v-chip",
                                                  {
                                                    staticClass: "white--text",
                                                    attrs: {
                                                      color: "orange",
                                                      small: ""
                                                    }
                                                  },
                                                  [
                                                    _c("span", [
                                                      _vm._v(
                                                        _vm._s(item.nombre)
                                                      )
                                                    ])
                                                  ]
                                                )
                                              : _vm._e(),
                                            _vm._v(" "),
                                            index === 5
                                              ? _c(
                                                  "v-chip",
                                                  {
                                                    staticClass: "white--text",
                                                    attrs: {
                                                      color: "orange",
                                                      small: ""
                                                    }
                                                  },
                                                  [
                                                    _c("span", [
                                                      _vm._v(
                                                        _vm._s(item.nombre)
                                                      )
                                                    ])
                                                  ]
                                                )
                                              : _vm._e(),
                                            _vm._v(" "),
                                            index === 6
                                              ? _c(
                                                  "v-chip",
                                                  {
                                                    staticClass: "white--text",
                                                    attrs: {
                                                      color: "orange",
                                                      small: ""
                                                    }
                                                  },
                                                  [
                                                    _c("span", [
                                                      _vm._v(
                                                        _vm._s(item.nombre)
                                                      )
                                                    ])
                                                  ]
                                                )
                                              : _vm._e(),
                                            _vm._v(" "),
                                            index === 7
                                              ? _c(
                                                  "v-chip",
                                                  {
                                                    staticClass: "white--text",
                                                    attrs: {
                                                      color: "orange",
                                                      small: ""
                                                    }
                                                  },
                                                  [
                                                    _c("span", [
                                                      _vm._v(
                                                        _vm._s(item.nombre)
                                                      )
                                                    ])
                                                  ]
                                                )
                                              : _vm._e()
                                          ],
                                          1
                                        )
                                      ]
                                    }
                                  }
                                ]),
                                model: {
                                  value: _vm.evento.servicios,
                                  callback: function($$v) {
                                    _vm.$set(_vm.evento, "servicios", $$v)
                                  },
                                  expression: "evento.servicios"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("strong", [
                        _vm.mascota.historial.length > 0
                          ? _c("p", { staticClass: "ml-4 my-0 pa-0" }, [
                              _vm._v("Historial")
                            ])
                          : _vm._e()
                      ]),
                      _vm._v(" "),
                      _c(
                        "v-row",
                        [
                          _c(
                            "v-row",
                            {
                              staticClass: "ma-0 pa-0",
                              attrs: { justify: "space-around" }
                            },
                            _vm._l(_vm.historial, function(item, i) {
                              return _c(
                                "v-col",
                                {
                                  key: i,
                                  staticClass: "pa-0 mx-0 my-1",
                                  attrs: { id: "historial", cols: "7" }
                                },
                                [
                                  _c(
                                    "v-btn",
                                    {
                                      attrs: {
                                        depressed: "",
                                        elevation: "2",
                                        small: "",
                                        block: "",
                                        outlined: "",
                                        color: _vm.isSelect(item)
                                      },
                                      on: {
                                        click: function($event) {
                                          return _vm.asignarServicio(item)
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        _vm._s(item.abreviacion) +
                                          "\n                                "
                                      )
                                    ]
                                  )
                                ],
                                1
                              )
                            }),
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
                    [
                      _c(
                        "v-col",
                        {
                          staticStyle: { "margin-top": "10px" },
                          attrs: { cols: "12", md: "5" }
                        },
                        [
                          _c(
                            "v-btn",
                            {
                              staticClass: "white--text",
                              attrs: {
                                rounded: "",
                                outlined: "",
                                color: "red accent-2"
                              },
                              on: { click: _vm.closeDialog }
                            },
                            [_vm._v("cerrar")]
                          ),
                          _vm._v(" "),
                          _vm.evento.id
                            ? _c(
                                "v-btn",
                                {
                                  staticClass: "white--text",
                                  attrs: {
                                    rounded: "",
                                    depressed: "",
                                    color: "red accent-2"
                                  },
                                  on: {
                                    click: function($event) {
                                      _vm.dialogocancelar = true
                                    }
                                  }
                                },
                                [_vm._v("eliminar")]
                              )
                            : _vm._e(),
                          _vm._v(" "),
                          _vm.evento.id
                            ? _c(
                                "v-btn",
                                {
                                  staticClass: "white--text",
                                  attrs: {
                                    rounded: "",
                                    outlined: "",
                                    color: _vm.evento.confirmada
                                      ? "grey"
                                      : "green"
                                  },
                                  on: { click: _vm.confirmarCita }
                                },
                                [
                                  _vm._v(
                                    _vm._s(
                                      _vm.evento.confirmada
                                        ? "Desconfirmar"
                                        : "Confirmar"
                                    )
                                  )
                                ]
                              )
                            : _vm._e()
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        {
                          staticClass: "my-1 py-1",
                          attrs: { cols: "12", md: "6" }
                        },
                        [
                          _c("v-date-picker", {
                            staticClass: "my-0 py-0 ml-4 ",
                            attrs: { color: "blue-grey lighten-1" },
                            on: {
                              change: function($event) {
                                return _vm.buscarDisponible()
                              }
                            },
                            model: {
                              value: _vm.evento.fecha,
                              callback: function($$v) {
                                _vm.$set(_vm.evento, "fecha", $$v)
                              },
                              expression: "evento.fecha"
                            }
                          }),
                          _vm._v(" "),
                          _c("v-row")
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "5" } },
                        [
                          _c(
                            "div",
                            {
                              staticStyle: {
                                "font-size": "12px !important",
                                "margin-top": "10px !important",
                                "margin-bottom": "10px !important"
                              }
                            },
                            [
                              _c("strong", [_vm._v("INICIO: ")]),
                              _vm._v(
                                " " +
                                  _vm._s(this.evento.start) +
                                  "\n                            "
                              ),
                              _c("strong", { staticClass: "ml-2" }, [
                                _vm._v("FIN: ")
                              ]),
                              _vm._v(
                                " " +
                                  _vm._s(this.evento.end) +
                                  "\n                            "
                              ),
                              _c("strong", { staticClass: "ml-2" }, [
                                _vm._v("DURACION: ")
                              ]),
                              _vm._v(
                                " " +
                                  _vm._s(this.evento.duracion) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _vm._l(_vm.local_horario, function(empleado, i) {
                            return _c(
                              "v-row",
                              {
                                key: empleado.app_empleado_id,
                                attrs: { dense: "" }
                              },
                              [
                                _c(
                                  "v-col",
                                  { attrs: { cols: "12" } },
                                  [
                                    empleado.horario.length > 0
                                      ? _c(
                                          "v-chip",
                                          {
                                            attrs: {
                                              small: "",
                                              color: "green",
                                              outlined: ""
                                            }
                                          },
                                          [
                                            _c(
                                              "v-icon",
                                              { attrs: { left: "" } },
                                              [_vm._v("mdi-account-clock")]
                                            ),
                                            _vm._v(
                                              _vm._s(empleado.nombre_empleado)
                                            )
                                          ],
                                          1
                                        )
                                      : _vm._e()
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _vm._l(empleado.horario, function(item, i) {
                                  return _c(
                                    "v-col",
                                    { key: i, attrs: { cols: "12", md: "3" } },
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          attrs: {
                                            elevation: "2",
                                            rounded: "",
                                            small: "",
                                            block: "",
                                            color: _vm.isSelect2(
                                              item,
                                              empleado.app_empleado_id
                                            )
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.asignarDatos(
                                                item,
                                                empleado.app_empleado_id
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _vm._v(
                                            _vm._s(item) +
                                              "\n                                "
                                          )
                                        ]
                                      )
                                    ],
                                    1
                                  )
                                })
                              ],
                              2
                            )
                          }),
                          _vm._v(" "),
                          _c(
                            "v-btn",
                            {
                              staticClass: "mt-2",
                              attrs: {
                                small: "",
                                block: "",
                                dark: "",
                                rounded: "",
                                color: "red"
                              },
                              on: {
                                click: function($event) {
                                  return _vm.asignarCita(
                                    _vm.dataItem,
                                    _vm.dataIdemp
                                  )
                                }
                              }
                            },
                            [_vm._v("Guardar - Modificar cita")]
                          ),
                          _vm._v(" "),
                          _c(
                            "v-container",
                            [
                              _c(
                                "v-dialog",
                                {
                                  attrs: { persistent: "", width: "400" },
                                  model: {
                                    value: _vm.dialogocancelar,
                                    callback: function($$v) {
                                      _vm.dialogocancelar = $$v
                                    },
                                    expression: "dialogocancelar"
                                  }
                                },
                                [
                                  [
                                    _c(
                                      "v-card",
                                      [
                                        _c(
                                          "v-card-title",
                                          {
                                            staticClass:
                                              "text-h5 green white--text"
                                          },
                                          [_vm._v("Eliminar cita")]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "v-col",
                                          {
                                            staticClass: "py-2",
                                            attrs: { cols: "12" }
                                          },
                                          [
                                            _c(
                                              "v-card-text",
                                              { staticClass: "mt-0 mb-0 pb-3" },
                                              [
                                                _c("h3", [
                                                  _vm._v(
                                                    "Para eliminar la cita debe indicar un motivo"
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "v-btn-toggle",
                                              {
                                                staticClass: "ml-3",
                                                attrs: {
                                                  color: "red accent-4",
                                                  rounded: ""
                                                },
                                                model: {
                                                  value: _vm.toggle_exclusive,
                                                  callback: function($$v) {
                                                    _vm.toggle_exclusive = $$v
                                                  },
                                                  expression: "toggle_exclusive"
                                                }
                                              },
                                              [
                                                _c(
                                                  "v-btn",
                                                  {
                                                    attrs: {
                                                      small: "",
                                                      elevation: "3"
                                                    }
                                                  },
                                                  [
                                                    _c("strong", [
                                                      _vm._v(" No asiste ")
                                                    ])
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "v-btn",
                                                  {
                                                    attrs: {
                                                      small: "",
                                                      elevation: "3"
                                                    }
                                                  },
                                                  [
                                                    _c("strong", [
                                                      _vm._v(
                                                        " Cancela cliente "
                                                      )
                                                    ])
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "v-btn",
                                                  {
                                                    attrs: {
                                                      small: "",
                                                      elevation: "3"
                                                    }
                                                  },
                                                  [
                                                    _c("strong", [
                                                      _vm._v(" Erronea ")
                                                    ])
                                                  ]
                                                )
                                              ],
                                              1
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "v-col",
                                              {
                                                staticClass:
                                                  "text-center mb-0 pb-0",
                                                attrs: { cols: "12" }
                                              },
                                              [
                                                _vm.toggle_exclusive == 0
                                                  ? _c("div", [
                                                      _c("h6", [
                                                        _vm._v(" No asiste ")
                                                      ])
                                                    ])
                                                  : _vm.toggle_exclusive == 1
                                                  ? _c("div", [
                                                      _c("h6", [
                                                        _vm._v(
                                                          " Cancela cliente "
                                                        )
                                                      ])
                                                    ])
                                                  : _vm.toggle_exclusive == 2
                                                  ? _c("div", [
                                                      _c("h6", [
                                                        _vm._v(" Erronea ")
                                                      ])
                                                    ])
                                                  : _vm._e()
                                              ]
                                            )
                                          ],
                                          1
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "v-col",
                                          [
                                            _c(
                                              "v-row",
                                              {
                                                attrs: {
                                                  align: "center",
                                                  justify: "center"
                                                }
                                              },
                                              [
                                                _vm.toggle_exclusive != null
                                                  ? _c(
                                                      "v-btn",
                                                      {
                                                        staticClass:
                                                          "white--text red mt-0 ml-4 mb-4",
                                                        attrs: {
                                                          small: "",
                                                          md: "3",
                                                          rounded: "",
                                                          depressed: "",
                                                          color: "danger"
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            return _vm.eliminarCita(
                                                              _vm.toggle_exclusive
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [_vm._v("Eliminar")]
                                                    )
                                                  : _vm._e(),
                                                _vm._v(" "),
                                                _c(
                                                  "v-btn",
                                                  {
                                                    staticClass:
                                                      "white--text mt-0 mx-2 mb-4",
                                                    attrs: {
                                                      small: "",
                                                      md: "3",
                                                      rounded: "",
                                                      depressed: "",
                                                      color: "success"
                                                    },
                                                    on: {
                                                      click: function($event) {
                                                        return _vm.cierraeliminar()
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
                                  ]
                                ],
                                2
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "v-container",
                            [
                              _c(
                                "v-dialog",
                                {
                                  attrs: { persistent: "", width: "280" },
                                  model: {
                                    value: _vm.dialogocita,
                                    callback: function($$v) {
                                      _vm.dialogocita = $$v
                                    },
                                    expression: "dialogocita"
                                  }
                                },
                                [
                                  [
                                    _c(
                                      "v-card",
                                      [
                                        _c(
                                          "v-card-title",
                                          {
                                            staticClass:
                                              "text-h5 green white--text"
                                          },
                                          [_vm._v("Datos Necesarios")]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "v-col",
                                          {
                                            staticClass: "ma-0 pb-0",
                                            attrs: { cols: "12" }
                                          },
                                          [
                                            _c(
                                              "v-card-text",
                                              { staticClass: "ma-0 pa-0 ml-2" },
                                              [
                                                _c("h4", [
                                                  _vm._v(
                                                    "Asigne dia en calendario y servicios"
                                                  )
                                                ]),
                                                _c("h4", [
                                                  _vm._v(
                                                    "Para consultar las citas disponibles"
                                                  )
                                                ])
                                              ]
                                            )
                                          ],
                                          1
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "v-col",
                                          [
                                            _c(
                                              "v-row",
                                              {
                                                staticClass: "pa-0 ma-0",
                                                attrs: {
                                                  align: "center",
                                                  justify: "center"
                                                }
                                              },
                                              [
                                                _c(
                                                  "v-btn",
                                                  {
                                                    staticClass:
                                                      "white--text ma-0",
                                                    attrs: {
                                                      small: "",
                                                      md: "3",
                                                      rounded: "",
                                                      depressed: "",
                                                      color: "success"
                                                    },
                                                    on: {
                                                      click: function($event) {
                                                        return _vm.cierraobligacita()
                                                      }
                                                    }
                                                  },
                                                  [_vm._v("Continuar")]
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
                                  ]
                                ],
                                2
                              )
                            ],
                            1
                          )
                        ],
                        2
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
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./vue_app/modulos/citas/componentes/Cita.vue":
/*!****************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/Cita.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Cita_vue_vue_type_template_id_52af0b6d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Cita.vue?vue&type=template&id=52af0b6d& */ "./vue_app/modulos/citas/componentes/Cita.vue?vue&type=template&id=52af0b6d&");
/* harmony import */ var _Cita_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Cita.vue?vue&type=script&lang=js& */ "./vue_app/modulos/citas/componentes/Cita.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _Cita_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Cita.vue?vue&type=style&index=0&media=screen&lang=css& */ "./vue_app/modulos/citas/componentes/Cita.vue?vue&type=style&index=0&media=screen&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Cita_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Cita_vue_vue_type_template_id_52af0b6d___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Cita_vue_vue_type_template_id_52af0b6d___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "vue_app/modulos/citas/componentes/Cita.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./vue_app/modulos/citas/componentes/Cita.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/Cita.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Cita_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Cita.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Cita_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./vue_app/modulos/citas/componentes/Cita.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!**************************************************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/Cita.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \**************************************************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Cita_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??ref--5-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--5-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Cita.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=style&index=0&media=screen&lang=css&");
/* empty/unused harmony star reexport */

/***/ }),

/***/ "./vue_app/modulos/citas/componentes/Cita.vue?vue&type=template&id=52af0b6d&":
/*!***********************************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/Cita.vue?vue&type=template&id=52af0b6d& ***!
  \***********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Cita_vue_vue_type_template_id_52af0b6d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Cita.vue?vue&type=template&id=52af0b6d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/Cita.vue?vue&type=template&id=52af0b6d&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Cita_vue_vue_type_template_id_52af0b6d___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Cita_vue_vue_type_template_id_52af0b6d___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./vue_app/modulos/citas/componentes/empleadoComponent.vue":
/*!*****************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/empleadoComponent.vue ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _empleadoComponent_vue_vue_type_template_id_3f205c68___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./empleadoComponent.vue?vue&type=template&id=3f205c68& */ "./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=template&id=3f205c68&");
/* harmony import */ var _empleadoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./empleadoComponent.vue?vue&type=script&lang=js& */ "./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _empleadoComponent_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css& */ "./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _empleadoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _empleadoComponent_vue_vue_type_template_id_3f205c68___WEBPACK_IMPORTED_MODULE_0__["render"],
  _empleadoComponent_vue_vue_type_template_id_3f205c68___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "vue_app/modulos/citas/componentes/empleadoComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_empleadoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./empleadoComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_empleadoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!***************************************************************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \***************************************************************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_empleadoComponent_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??ref--5-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--5-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=style&index=0&media=screen&lang=css&");
/* empty/unused harmony star reexport */

/***/ }),

/***/ "./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=template&id=3f205c68&":
/*!************************************************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=template&id=3f205c68& ***!
  \************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_empleadoComponent_vue_vue_type_template_id_3f205c68___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./empleadoComponent.vue?vue&type=template&id=3f205c68& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/empleadoComponent.vue?vue&type=template&id=3f205c68&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_empleadoComponent_vue_vue_type_template_id_3f205c68___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_empleadoComponent_vue_vue_type_template_id_3f205c68___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./vue_app/modulos/citas/componentes/eventoComponent.vue":
/*!***************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/eventoComponent.vue ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _eventoComponent_vue_vue_type_template_id_5867c3de___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./eventoComponent.vue?vue&type=template&id=5867c3de& */ "./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=template&id=5867c3de&");
/* harmony import */ var _eventoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./eventoComponent.vue?vue&type=script&lang=js& */ "./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _eventoComponent_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css& */ "./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _eventoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _eventoComponent_vue_vue_type_template_id_5867c3de___WEBPACK_IMPORTED_MODULE_0__["render"],
  _eventoComponent_vue_vue_type_template_id_5867c3de___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "vue_app/modulos/citas/componentes/eventoComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_eventoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./eventoComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_eventoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!*************************************************************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \*************************************************************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_eventoComponent_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??ref--5-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--5-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=style&index=0&media=screen&lang=css&");
/* empty/unused harmony star reexport */

/***/ }),

/***/ "./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=template&id=5867c3de&":
/*!**********************************************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=template&id=5867c3de& ***!
  \**********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_eventoComponent_vue_vue_type_template_id_5867c3de___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./eventoComponent.vue?vue&type=template&id=5867c3de& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/eventoComponent.vue?vue&type=template&id=5867c3de&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_eventoComponent_vue_vue_type_template_id_5867c3de___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_eventoComponent_vue_vue_type_template_id_5867c3de___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./vue_app/modulos/citas/handlers/eventbus.js":
/*!****************************************************!*\
  !*** ./vue_app/modulos/citas/handlers/eventbus.js ***!
  \****************************************************/
/*! exports provided: EventBus */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "EventBus", function() { return EventBus; });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var EventBus = new vue__WEBPACK_IMPORTED_MODULE_0___default.a();

/***/ }),

/***/ "./vue_app/modulos/citas/mixins/data_mixin.js":
/*!****************************************************!*\
  !*** ./vue_app/modulos/citas/mixins/data_mixin.js ***!
  \****************************************************/
/*! exports provided: data_mixin */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "data_mixin", function() { return data_mixin; });
var data_mixin = {
  data: function data() {
    return {
      tienda: 8,
      tiendas: [],
      empleados: [],
      servicios: [],
      clientes: []
    };
  },
  methods: {
    getTiendas: function getTiendas() {
      var _this = this;

      axios.get("api/app/gettiendas").then(function (res) {
        _this.tiendas = res.data;
      }, function (res) {
        _this.$toast.error('Error consultando tiendas');
      });
    },
    getData: function getData(nombre_tipo, tienda_id) {
      var _this2 = this;

      console.log("GETDATA");
      console.log(nombre_tipo);
      console.log(tienda_id);
      axios.get("api/app/getdata/".concat(nombre_tipo, "/").concat(tienda_id)).then(function (res) {
        _this2.empleados = res.data.empleados;
        console.log("EMPLEADOS");
        console.log(_this2.empleados);
        _this2.servicios = res.data.servicios;
        console.log("SERVICIOS");
        console.log(_this2.servicios);
        _this2.clientes = res.data.clientes;
        console.log("CLIENTES");
        console.log(_this2.clientes);

        _this2.agregarCitas(_this2.dia_actual);

        _this2.overlay = false;
      }, function (res) {});
    }
  }
};

/***/ })

}]);