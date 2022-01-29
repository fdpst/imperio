<template>
    <v-navigation-drawer color="white" @input="getthe" v-model="local_drawer" :mini-variant="mini" app class="elevation-4">

        <div class="background-nav"></div>

        <v-list-item @click.stop="mini = !mini" class="avatar-b-color">

            <v-list-item-content>
                <v-list-item-title class="text-center">
                    <img style="width:75%;margin:auto;" :src="'favicon.png'"/>
                </v-list-item-title>
            </v-list-item-content>

        </v-list-item>

        <v-divider></v-divider>

        <default-lateral></default-lateral>

    </v-navigation-drawer>

</template>

<script>
    import defaultLateral from './defaultLateral.vue'
    export default {
        props: ['drawer'],
        components: {
            defaultLateral
        },
        methods: {
            getthe(e) {
                this.$emit('emitInnputDrawer', e)
            }
        },
        data() {
            return {
                lateral: 'defaultLateral',
                mini: false,
                local_drawer: true,
            }
        },
        watch: {
            drawer: {
                immediate: true,
                handler: function(n) {
                    this.local_drawer = n
                }
            },
            computed: {
                auth() {
                    //return this.$store.getters.getauth
                    return 'a'
                },
                user() {
                    return 'u'
                    //  return this.$store.getters.getuser
                }
            }
        }
    }
</script>

<style media="screen">
    .v-navigation-drawer .v-list .v-list-item>.v-list__tile .v-list__tile__title {
        font-size: 14px !important;
        font-weight: 100;
        padding: 0;
    }

    .v-list--dense .v-list-item .v-list-item__subtitle,
    .v-list--dense .v-list-item .v-list-item__title,
    .v-list-item--dense .v-list-item__subtitle,
    .v-list-item--dense .v-list-item__title {
        font-size: 17px !important;
        font-weight: 700 !important;
    }

    .v-application--is-ltr .v-list-item__action:first-child,
    .v-application--is-ltr .v-list-item__icon:first-child {
        margin-right: 15px;
    }

    .v-list--dense .v-list-item .v-list-item__icon,
    .v-list-item--dense .v-list-item__icon {
        opacity: .9;
        color: #fff;
    }

    .v-list--nav .v-list-item {
        padding: 5px 15px;
    }

    .v-list-item--active:before,
    .v-list-item--active:hover:before,
    .v-list-item:focus:before {
        opacity: 1;
    }

    .theme--dark.v-list-item--active:before,
    .theme--dark.v-list-item--active:hover:before,
    .theme--dark.v-list-item:focus:before {
        opacity: 0;
    }

    .avatar-b-color {
        background-color: #fff !important;
    }

    .v-list-item--active{
        background-color: #59fee2 !important;
    }
</style>