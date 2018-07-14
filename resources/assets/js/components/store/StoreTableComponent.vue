<template>
    <div class="container">
        <h1 class="justify-content-center">Склады {{firm.name.name}}</h1>
        <vuetable ref="vuetable"
                  :api-url="ApiUrl"
                  :fields="fields"
                  data-path=""
                  pagination-data=""
                  :css="css"
                  :sort-order="sortOrder"
                  :append-params="moreParams"
        >
            <template slot="actions" slot-scope="props">
                <div class="custom-actions">
                    <div class="btn btn-sm"
                         @click="onAction('edit-item', props.rowData, props.rowIndex)">
                        <i class="my-icons edit-icon"></i>
                    </div>
                    <div class="btn btn-sm"
                         @click="onAction('delete-item', props.rowData, props.rowIndex)">
                        <i class="my-icons dustbin-icon"></i>
                    </div>
                </div>
            </template>
        </vuetable>
        <b-button size="sm" class="col-md-2" @click="add">Новый склад</b-button>
        <store-edit-component v-if="editing" v-model="rowData" :firmname="firm.name.name" :ApiUrl="ApiUrl" ref="StoreEditForm" @close="EditClose"></store-edit-component>
    </div>

</template>

<script>
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import BootstrapStyle from '../bootstrap-css.js'
    import bModal from 'bootstrap-vue/es/components/modal/modal'
    import StoreEditComponent from "./StoreEditComponent";
    import bButton from 'bootstrap-vue/es/components/button/button';
    export default {
        name: "StoreTableComponent",
        props:['ApiUrl','firm'],
        components: {
            StoreEditComponent,
            Vuetable,
            bModal,
            bButton
        },
        data(){
            return {
                editing:false,
                moreParams: {},
                rowData: {id:0,name_id:0,name:{id:0,name:''},firm_id:0,firm:{id:0,name:{id:0,name:''}}},
                css: BootstrapStyle,
                fields:[
                    {name:'name.name', title:'Название'},
                    {
                        name: '__slot:actions',
                        title: 'Операции',
                        titleClass: 'center aligned',
                        dataClass: 'center aligned'
                    }
                ],
                sortOrder: [
                    {
                        field: 'name.name',
                        sortField: 'name.name',
                        direction: 'asc'
                    }
                ]
            }
        },
        created() {
            this.moreParams = {firm_id:this.firm.id};
        },
        watch: {
            firm: function(newVal,oldVal){
                this.moreParams = {firm_id:newVal.id};
                let that = this;
                Vue.nextTick(function () {
                    that.tableReload();
                });
            }
        },
        methods: {
            onAction (action, data, index) {
                this.rowData = data;
                if (action == 'delete-item'){
                    axios.delete(this.ApiUrl+'/'+this.rowData.id)
                        .then(response => {
                            this.$refs.vuetable.refresh();
                        });
                } else {
                    this.editing = true;
                }
            },
            tableReload () {
                this.$refs.vuetable.reload();
            },
            EditClose () {
                this.$refs.vuetable.refresh();
                this.editing=false;
            },
            add(){
                this.rowData = {id:0,name_id:0,name:{id:0,name:''},firm_id:this.firm.id,firm:this.firm};
                this.editing=true;
                //this.$refs.StoreEditForm.clearErrors();
            }
        }
    }
</script>

<style scoped>

</style>