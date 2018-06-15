<template>
        <div class="row">
            <div class="col-md-1 left-slider" @click="LeftClick"></div>
            <div class="col-md-10 image-box">
                <img v-if="ind>=0" :src="images[ind].path" class="image-picture"/>
                <div class="image-point" >
                    <div v-for="(image, index) in images" v-bind:class="{ 'image-select': index == ind }" @click="ImageSelect(index)"></div>
                </div>
                <div class="image-crud">
                    <div class="btn btn-sm my-icons add-icon" @click="UploadPicture"></div>
                    <div class="btn btn-sm my-icons dustbin-icon" @click="DeletePicture"></div>
                </div>
            </div>
            <div class="col-md-1 right-slider" @click="RightClick"></div>
            <input type="file" @change="onFileChanged" style="display:none" ref="SelectFile">
        </div>
</template>

<script>
    export default {
        props:['value'],
        data(){
            return{
                ind:-1,
                images:[

                ],
            }
        },
        methods: {
            LeftClick() {
                if (this.ind>0) this.ind--;
            },
            RightClick() {
                if (this.ind < this.images.length - 1) this.ind++
            },
            UploadPicture() {
                this.$refs.SelectFile.click();
            },
            onFileChanged(){
                var formData = new FormData();
                formData.append('image', this.$refs.SelectFile.files[0])

                axios({
                    url: 'pictures',
                    method: 'POST',
                    data: formData
                })
                    .then((result) => {
                       // let url = result.data.url // Get url from response
                       // console.log(url);
                       this.images.push(result.data);
                       this.ind = this.images.length-1;
                    })
                    .catch((err) => {
                        console.log(err);
                    })
            },
            DeletePicture(){
                if (this.ind>=0) {
                    var oldInd = this.ind;
                    this.images.splice(oldInd,1);
                    if (this.images.length==0 || this.ind!=0)
                        this.ind--;
                }
            },
            ImageSelect(index) {
                this.ind = index;
            }
        },
        watch:{
            value: function(newVal, oldVal) {
                this.images = newVal;
                if (this.images.length>0)
                    this.ind = 0;
            }
        }
    }
</script>

<style scoped>
    .image-box {
        height: 350px;
        width: auto;
        display:flex;
        flex-flow:row nowrap;
        justify-content:center;
        position:relative;
    }
    .image-picture {
        height: 100%;
        width: auto;
    }
    .image-point {
        display:flex;
        flex-flow: row nowrap;
        justify-content: center;
        position:absolute;
        top: 90%;
    }
    .image-point div {
        width:10px;
        height:10px;
        background-color:#c5c5c5;
        border-radius:50%;
        margin:5px 10px;
    }
    .image-point .image-select {
        background-color:black;
    }
    .image-crud {
        display:flex;
        flex-direction: column;

        position:absolute;
        left:0%;
    }
    .image-crud div {
        margin:5px 10px;
    }
</style>