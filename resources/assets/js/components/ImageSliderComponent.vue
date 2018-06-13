<template>

        <div class="row">
            <div class="col-md-1 left-slider" @click="LeftClick"></div>
            <div class="col-md-9"><img :src="images[index]"/></div>
            <div class="col-md-1 right-slider" @click="RightClick"></div>
            <div class="col-md-1">
                <div class="btn btn-sm my-icons add-icon"></div>
                <div class="btn btn-sm my-icons dustbin-icon"></div>
            </div>
        </div>
</template>

<script>
    export default {
        data(){
            return{
                index:0,
                images:[
                    'images/W/WatsApp Image 2018-05-08 at 12.10.57.jpeg',
                    'images/p/photo_2018-03-25_08-12-01.jpg'
                ],
            }
        },
        methods: {
            LeftClick() {
                if (this.index>0) this.index--;
            },
            RightClick() {
                if (this.index < images.length - 1) this.index++
            }
        }
    }
</script>

<style scoped>

</style>