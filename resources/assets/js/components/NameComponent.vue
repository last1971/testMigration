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
                val: this.value,
            }
        },
        mounted(){
            if (this.val!==undefined){
                this.$refs.autocomplete.setValue(this.val.name);
                if (this.val.id==0)
                    this.val = undefined;
            }
        },
        watch: {
            value: function(newVal, oldVal) { // watch it
                if (this.val != newVal) {
                    if (newVal !== undefined) {
                        this.$refs.autocomplete.setValue(newVal.name);
                        if (newVal.id > 0)
                            this.val = newVal;
                        else
                            this.val = undefined;
                    } else {
                        this.val = undefined;
                    }
                }
            },
            val: function() {
                this.$emit('input',this.val);
            }
        },
        methods: {
            getData(obj){
                this.val = obj;
            },
            clearValue(){
                this.val = undefined;
            },
            checkValue(){
                var that = this;
                setTimeout(function() {
                    if (that.val === undefined && that.$refs.autocomplete.type.length>0) {
                        axios.get('names/0?name=' + that.$refs.autocomplete.type)
                            .then(response => {
                                if (response.data.id != 0) {
                                    that.val = response.data;
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
                    })
                    .catch(e => {console.log(e);});
            },
        }
    }
</script>

<style scoped>

</style>