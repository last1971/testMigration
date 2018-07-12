<template>
    <div class="div-border" @click="SelectFile">
        <img v-if="value && value.id>0" :src="value.path" />
        <div v-else>Кликни для установки картинки</div>
        <input type="file" @change="onFileChanged" style="display:none" ref="SelectFile">
    </div>
</template>

<script>
    export default {
        name: "ImageSelectComponent",
        props: ["value"],
        methods:{
            SelectFile(){
                this.$refs.SelectFile.click();
            },
            onFileChanged(){
                if (this.$refs.SelectFile.files.length>0) {
                    var formData = new FormData();
                    formData.append('image', this.$refs.SelectFile.files[0])

                    axios({
                        url: 'pictures',
                        method: 'POST',
                        data: formData
                    })
                        .then((result) => {
                            this.$emit('input',result.data);
                        })
                        .catch((err) => {
                            console.log(err);
                        })
                }
            },
        }
    }
</script>

<style scoped>
    .div-border {
        border-width:1px;
        border-color: rgb(190,190,190);
        border-style: solid;
    }
</style>