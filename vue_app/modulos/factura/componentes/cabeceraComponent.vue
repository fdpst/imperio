<template>                       
  <v-container class="grey lighten-3 pa-0 mt-1" ><div class="ml-3" id="client"><strong>Ticket</strong><v-divider></v-divider></div>
    <v-row no-gutters style="height: 30px" v-if="cliente.id != null">
      <v-col class="ml-1 pa-1">
        <v-icon class="mr-3">mdi-account</v-icon>
        <strong>{{cliente.nombre}}</strong>
      </v-col>
    </v-row>
    <v-row no-gutters style="height: 30px">
      <v-col class="mt-1 mb-2 ml-4 mr-0"><p id="cabecera"><strong>Item</strong></p></v-col>
      <v-col class="mt-1 mb-2 ml-2"><p id="cabecera"><strong>Uds.</strong></p></v-col>
      <v-col class="mt-1 mb-2 ml-0 mr-2"><p id="cabecera"><strong>Precio</strong></p></v-col>
      <v-col class="mt-1 mb-2 mr-4"><p id="cabecera"><strong>Total</strong></p></v-col>
    </v-row>
  </v-container>
</template>

<script>
    export default {
      props: ['cliente']
    }
</script>

<style media="screen">
@media (min-width:1265px) and (max-width:2560px){
  div#client.ml-3{
    display: none;
  }
}
</style>