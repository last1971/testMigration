<template>
    <div class="col-md-12">
    <div class="row">
        <autocomplete ref="autocomplete"
                      url="/articles"
                      :customParams="{ ac: 1 }"
                      anchor="name.name"
                      label="short_text"
                      :classes="{ wrapper: 'col-md-8', input: 'form-control', list: 'data-list', item: 'data-list-item' }"
                      :on-select="getData"
                      :on-input="clearValue"
                      :on-blur="checkValue"
                      placeholder="Статья"
        ></autocomplete>
        <b-button v-if="val===undefined" class="col-md-4" @click="handleOk">Добавить</b-button>
    </div>
        <div class="row" v-if="add_visible">
            <article-edit-component v-model="exch_val" class="col-md-12" v-on:closearticlestable="CloseEdit"></article-edit-component>
        </div>
    </div>
</template>

<script>
    import ArticleEditComponent from "./ArticleEditComponent";
    require('vue2-autocomplete-js/dist/style/vue2-autocomplete.css')
    import Autocomplete from 'vue2-autocomplete-js'

    import bButton from 'bootstrap-vue/es/components/button/button';
    export default {
        name: "ArticleSelectComponent",
        props: ['value'],
        components: {
            ArticleEditComponent,
            Autocomplete,
            bButton,

        },
        data() {
            return {
                val: undefined,
                exch_val: {id:0,name:{id:0,name:''},short_name:'',content:''},
                add_visible:false
            }
        },
        watch: {
            value: function (newVal, oldVal) { // watch it
                if (newVal != this.val) {
                    if (newVal !== undefined)
                        if (newVal == null) this.$refs.autocomplete.setValue('');
                        else this.$refs.autocomplete.setValue(newVal.name.name);
                    this.val = newVal;
                }
            },
            val: function () {
                this.$emit('input', this.val);
            }
        },
        methods: {
            getData(obj) {
                this.val = obj;
                this.$refs.autocomplete.setValue(this.val.name.name);
            },
            clearValue() {
                this.val = undefined;
            },
            checkValue() {
                var that = this;
                setTimeout(function () {
                    if (that.val === undefined && that.$refs.autocomplete.type.length > 0) {
                        axios.get('articles/0?name=' + that.$refs.autocomplete.type)
                            .then(response => {
                                if (response.data.id != 0) {
//                                    that.val = response.data;
                                }
                            })
                            .catch(e => {
                                console.log(e);
                            });
                    }
                }, 125);
            },
            handleOk() {
                this.add_visible=true;
                this.exch_val = {id:0,name:{id:0,name:this.$refs.autocomplete.type},short_name:'',content:''};
            },
            CloseEdit(){
                this.val = this.exch_val;
                this.add_visible=false;
            }
        }
    }
</script>

<style scoped>

</style>