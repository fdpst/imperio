<template>
  <div class="mb-10">
    <v-row
      align="center"
    >
      <v-col cols="12" class="padding-responsive">
        <v-autocomplete
          v-model="tienda"
          :items="tiendas"
          label="Tienda"
          outlined
          chips
          color="red lighten-2"
          class="ma-4 mx-4 border-autocomplete"
          @change="changeTienda"
          item-text="nombre" 
          item-value="id"
        >
          <template v-slot:selection="data">
            <div>
              <v-list-item>
                <v-list-item-avatar>
                  <v-icon
                    class="rounded-circle grey lighten-4"
                  >
                    mdi-store
                  </v-icon>
                </v-list-item-avatar>

                <v-list-item-content>
                  <v-list-item-title >{{data.item.nombre}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </div>
          </template>
        </v-autocomplete>
      </v-col>
    </v-row>
    <v-responsive
      class="overflow-y-auto mt-2"
      max-height="500"
      v-if="tienda"
    >
      <v-row justify="space-between" align="center" class="mx-2" v-for="servicio in servicios" :key="servicio.id">
        <v-col cols="10" class="py-0">
          <v-checkbox
            off-icon="mdi-checkbox-blank-circle-outline"
            on-icon="mdi-checkbox-marked-circle"
            class="text--primary"
            v-model="radioGroup"
            color="red lighten-2"
            :label="servicio.nombre"
            :value="servicio"
            @click="$emit('selectServicios')"
          >
            <template v-slot:label>
              <h5>
                {{servicio.nombre}}
              </h5>
            </template>
          </v-checkbox>
        </v-col>
        <v-col cols="2">
          <h5 class="d-flex justify-end text--secondary"> </h5> 
        </v-col>
      </v-row>
    </v-responsive>
  </div>
</template>

<script>
export default {
  props:['servicios', 'tiendas'],
  data () {
    return {
      radioGroup: [],
      isActive: false,
      tienda: 1,
    }
  },
  mounted() {
      this.$emit('getData', this.tienda);
    },
  methods:
  {
    changeTienda()
    {
      console.log(this.radioGroup)
      this.$emit('getData', this.tienda);
    }
  }

}
</script>

<style>

</style>