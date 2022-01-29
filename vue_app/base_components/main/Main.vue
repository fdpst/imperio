<template>
    <v-app>
        <top v-if="$route.path !== '/login' && $route.path !== '/pedir-cita'" v-on:toggleDrawer="toggleDrawer"></top>
        <lateral v-if="$route.path !== '/login' && $route.path !== '/pedir-cita'" :drawer="drawer" v-on:emitInnputDrawer="getInnputDrawer"></lateral>

        <v-content color="purple darken-3">
            <v-container fluid grid-list-xs :class="$route.path == '/login' || $route.path == '/pedir-cita' ? 'pa-0': ''" >
                <router-view :key="$route.path"></router-view>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import Top from '../navs/Top.vue'
    import Lateral from '../navs/Lateral.vue'
    export default {
        components: {
            Top,
            Lateral
        },
        watch: {
            drawer: {
                immediate: true,
                handler: function(n) {

                }
            },
        },
        data() {
            return {
                drawer: true
            }
        },
        methods: {
            isActive() {
                return false //this.$route.path != '/login'
            },
            toggleDrawer() {
                this.drawer = !this.drawer
            },
            getInnputDrawer(e) {
                this.drawer = e
            }
        },
    }
</script>

<style media="screen">
    .my-container {
        padding: 1rem;
    }

    .v-content__wrap {
        background-color: #efeeee;
    }

    a {
        text-decoration: none;
    }

    /*.v-toolbar__title {
        font-weight: 300;
        color: #555;
        font-size: 18px;
        margin-bottom: 6px;
    }*/
</style>