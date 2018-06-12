<template>
    <div class="row col-md-12">
        <autocomplete ref="autocomplete"
            url="/names"
            anchor="name"
            label=""
            :classes="{ wrapper: 'col-md-8', input: 'form-control', list: 'data-list', item: 'data-list-item' }"
            :on-select="getData"
            :on-input="clearValue"
            :on-blur="checkValue"
            placeholder="Наименование"
        ></autocomplete>
        <b-button v-if="val===undefined" class="col-md-4" @click="handleOk">Добавить</b-button>
    </div>
</template>

<script>

    require('vue2-autocomplete-js/dist/style/vue2-autocomplete.css')
    import Autocomplete from 'vue2-autocomplete-js'
    import bButton from 'bootstrap-vue/es/components/button/button';
    export default {
        props:['value'],
        components:{
            Autocomplete,
            bButton
        },
        data() {
            return {
                val: undefined,
                aga: true
            }
        },
        watch: {
            value: function(newVal, oldVal) { // watch it
                if (this.aga) {
                    if (newVal !== undefined)
                        this.$refs.autocomplete.setValue(newVal.name);
                    this.val = newVal;
                    this.aga = false;
                } else {
                    this.aga = true;
                }
            },
            val: function() {
                this.aga = false;
                this.$emit('input',this.val);
            }
        },
        methods: {
            getData(obj){
                this.val = obj;
                this.$emit('input',this.val);
            },
            clearValue(){
                this.val = undefined;
                this.$emit('input',this.val);
            },
            checkValue(){
                var that = this;
                setTimeout(function() {
                    if (that.val === undefined && that.$refs.autocomplete.type.length>0) {
                        axios.get('names/0?name=' + that.$refs.autocomplete.type)
                            .then(response => {
                                if (response.data.id != 0) {
                                    that.val = response.data;
                                    that.$emit('input',this.val);
                                }
                            })
                            .catch(e => {
                                console.log(e);
                            });
                    }
                },125);
            },
            handleOk(){
                axios.post('names',{name:this.$refs.autocomplete.type})
                    .then(response => {
                        this.val = response.data;
                        this.$emit('input',this.val);
                    })
                    .catch(e => {console.log(e);});
            },
        }
    }
</script>

<style scoped>

</style>