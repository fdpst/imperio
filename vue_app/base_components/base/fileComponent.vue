<template>
    <v-file-input @change="onFileChange" :label="label"></v-file-input>
</template>

<script>
    export default {
        props: {
            label: {
                default: 'Archivo',
                type: String
            }
        },
        methods: {
            onFileChange: function(e) {
                this.createImage(e)
            },
            createImage: function(file) {
                let reader = new FileReader()
                reader.onload = (e) => {
                    this.$emit('file_has_changed', e.target.result)
                };
                reader.readAsDataURL(file)
            }
        }
    }
</script>