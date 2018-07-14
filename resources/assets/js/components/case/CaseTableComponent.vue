<template>
    <div class="container">
        <h1 class="justify-content-centerr">Корпуса</h1>
        <filter-bar-componet v-on:filterChange="filterChange"></filter-bar-componet>
        <vuetable ref="vuetable"
                  :api-url="ApiUrl"
                  pagination-path=""
                  @vuetable:pagination-data="onPaginationData"
                  :per-page="10"
                  :fields="fields"
                  :css="css"
                  :sort-order="sortOrder"
                  :append-params="moreParams"
        >
            <template slot="image" slot-scope="props">
                <img v-if="props.rowData.picture_id>0" :src="props.rowData.picture.path" alt="" width="50" height="50">
            </template>
            <template slot="actions" slot-scope="props">
                <div class="custom-actions">
                    <div class="btn btn-sm" v-b-modal.caseeditmodal
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
        <div class="vuetable-pagination row align-self-center">
            <b-button size="sm" class="col-md-2" @click="addNewCase">Создать корпус</b-button>
            <div class="col-md-10">
                <vuetable-pagination-info ref="paginationInfo"
                                          :css="css.pagination"
                                          :info-template="infoTemplate"
                ></vuetable-pagination-info>
                <vuetable-pagination ref="pagination"
                                     :css="css.pagination"
                                     @vuetable-pagination:change-page="onChangePage"
                ></vuetable-pagination>
            </div>
        </div>
        <b-modal
                ref="CaseEdit"
                id="caseeditmodal"
                title="Редактировать информацию о корпусе"
                ok-only
                @ok="handleOk"
                @hide="tableReload"
                size="lg"
        >
            <case-edit-component v-model="rowData" ref="CaseEditForm" v-on:closecasestable="ModalClose"></case-edit-component>
        </b-modal>
    </div>

</template>

<script>
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import BootstrapStyle from '../bootstrap-css.js'
    import CaseEditComponent from './CaseEditComponent'
    import FilterBarComponet from '../FilterBarComponent'
    import bModal from 'bootstrap-vue/es/components/modal/modal'
    import bButton from 'bootstrap-vue/es/components/button/button';
    export default {
        name: "CaseTableComponent",
        props:['ApiUrl'],
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo,
            CaseEditComponent,
            bModal,
            bButton,
            FilterBarComponet,
        },
        data(){
            return {
                moreParams: {},
                rowData: {id:0,name_id:0,name:{id:0,name:''},pictures:[],article:{id:0,name:{id:0,name:''}}},
                css: BootstrapStyle,
                infoTemplate : "Показано с {from} по {to} из {total} записей",
                fields:[
                    {name:'name.name', title:'Название'},
                    {name:'article.short_text', title:'Описание'},
                    {
                        name: '__slot:image',
                        title: 'Рис.',
                        titleClass: 'center aligned',
                        dataClass: 'center aligned'
                    },
                    {
                        name: '__slot:actions',
                        title: 'Операции',
                        titleClass: 'center aligned',
                        dataClass: 'center aligned'
                    }
                ],
                customFilters: ['alphabet','name.name'],
                sortOrder: [
                    {
                        field: 'name.name',
                        sortField: 'name.name',
                        direction: 'asc'
                    }
                ]
            }
        },
        methods: {
            filterChange (data){
                if (data.length == 0) this.moreParams = {}
                else this.moreParams.q = data;
                var that = this
                Vue.nextTick( function() {
                    that.$refs.vuetable.refresh()
                })
            },
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData);
                this.$refs.paginationInfo.setPaginationData(paginationData);
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
            onAction (action, data, index) {
                this.rowData = data;
                this.$refs.CaseEditForm.clearErrors();
                if (action == 'delete-item'){
                    axios.delete(this.ApiUrl+'/'+this.rowData.id)
                        .then(response => {
                            this.$refs.vuetable.refresh();
                        });
                }
            },
            handleOk (evt){
                evt.preventDefault();
                this.$refs.CaseEditForm.save();
            },
            tableReload () {
                this.$refs.vuetable.reload();
            },
            ModalClose () {
                this.$refs.CaseEdit.hide();
            },
            addNewCase(){
                this.rowData = {id:0,name_id:0,name:{id:0,name:''},pictures:[],article:{id:0,name:{id:0,name:''}}};
                this.$refs.CaseEditForm.clearErrors();
                this.$refs.CaseEdit.show();
            }
        }
    }
</script>

<style scoped>

</style>