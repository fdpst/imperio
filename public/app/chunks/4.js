(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[4],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  data: function data() {
    return {
      horas: ['09:00', '09:15', '09:30', '09:45', '10:00'],
      duracion: 45,
      resultados: null,
      alert: false,
      empleados: [],
      tiendas: [],
      tipos: [],
      query: {
        empleado_id: null,
        tienda_id: null,
        tipo_id: null,
        fecha: null
      },
      resultado: {
        diferencia: []
      },
      cita: {
        start: '',
        duracion: 45,
        intervalos: []
      }
    };
  },
  created: function created() {
    this.getEmpleados();
    this.getTiendas();
    this.getTipos();
  },
  methods: {
    calcular: function calcular() {
      var intervalos = this.duracion / 15 + 1;

      for (var i = 0; i < this.horas.length; i++) {
        var start = moment("2021-03-26 ".concat(this.horas[i]), 'YYYY-MM-DD HH:mm');

        for (var j = 0; j < intervalos; j++) {
          var o = j * 15;
          var end = start.clone().add(o, 'minutes').format('HH:mm');

          if (!this.horas.includes(end)) {
            this.horas.splice(i, 1);
            i--;
            break;
          }
        }
      }
    },
    asignarCita: function asignarCita() {
      var _this = this;

      var intervalos = this.cita.duracion / 15 + 1;
      var start = moment("".concat(this.query.fecha, " ").concat(this.cita.start), 'YYYY-MM-DD HH:mm');

      var horarios = _.range(intervalos).map(function (x) {
        var i = x * 15;
        return start.clone().add(i, 'minutes').format('HH:mm');
      });

      var encaja_en_horario = horarios.every(function (element) {
        return _this.resultado.diferencia.includes(element);
      });

      if (encaja_en_horario) {
        this.$toast.sucs('se puede editar');
      } else {
        this.$toast.warn('no se puede editar');
      }
    },
    buscarDisponible: function buscarDisponible() {
      var _this2 = this;

      axios.post("api/app/buscar-horario-disponible", this.query).then(function (res) {
        _this2.resultado = res.data;

        _this2.$toast.sucs('consulta realizada');

        _this2.alert = true;
      }, function (res) {});
    },
    getTiendas: function getTiendas() {
      var _this3 = this;

      axios.get("api/app/gettiendas").then(function (res) {
        _this3.tiendas = res.data;
      }, function (res) {});
    },
    getTipos: function getTipos() {
      var _this4 = this;

      axios.get("api/app/gettipos").then(function (res) {
        _this4.tipos = res.data;
      }, function (res) {});
    },
    getEmpleados: function getEmpleados() {
      var _this5 = this;

      axios.get('api/app/getempleados').then(function (res) {
        _this5.empleados = res.data;
      }, function (err) {});
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=template&id=19cc45c6&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=template&id=19cc45c6& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
  return _c("v-container", [
    _c("pre", [_vm._v(_vm._s(_vm.horas))]),
    _vm._v(" "),
    _c("pre", [_vm._v(_vm._s(_vm.duracion))]),
    _vm._v(" "),
    _c("button", { on: { click: _vm.calcular } }, [_vm._v("calcular")]),
    _vm._v(" "),
    _c("pre", [_vm._v(_vm._s(_vm.resultados))])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./vue_app/modulos/citas/componentes/HorasDisponibles.vue":
/*!****************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/HorasDisponibles.vue ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _HorasDisponibles_vue_vue_type_template_id_19cc45c6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HorasDisponibles.vue?vue&type=template&id=19cc45c6& */ "./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=template&id=19cc45c6&");
/* harmony import */ var _HorasDisponibles_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HorasDisponibles.vue?vue&type=script&lang=js& */ "./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _HorasDisponibles_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _HorasDisponibles_vue_vue_type_template_id_19cc45c6___WEBPACK_IMPORTED_MODULE_0__["render"],
  _HorasDisponibles_vue_vue_type_template_id_19cc45c6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "vue_app/modulos/citas/componentes/HorasDisponibles.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HorasDisponibles_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./HorasDisponibles.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HorasDisponibles_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=template&id=19cc45c6&":
/*!***********************************************************************************************!*\
  !*** ./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=template&id=19cc45c6& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorasDisponibles_vue_vue_type_template_id_19cc45c6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./HorasDisponibles.vue?vue&type=template&id=19cc45c6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./vue_app/modulos/citas/componentes/HorasDisponibles.vue?vue&type=template&id=19cc45c6&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorasDisponibles_vue_vue_type_template_id_19cc45c6___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HorasDisponibles_vue_vue_type_template_id_19cc45c6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);