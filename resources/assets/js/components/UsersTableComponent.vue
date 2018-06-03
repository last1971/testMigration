<template>
    <div class="container">
        <vuetable ref="vuetable"
                  :api-url="ApiUrl"
                  pagination-path=""
                  @vuetable:pagination-data="onPaginationData"
                  :per-page="2"
                  :fields="fields"
                  :css="css"
                  :sort-order="sortOrder"
        >
            <template slot="actions" slot-scope="props">
                <div class="custom-actions">
                    <div class="btn btn-sm" v-b-modal.usereditmodal
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
        <div class="vuetable-pagination">
            <vuetable-pagination-info ref="paginationInfo"
                                      :css="css.pagination"
                                      :info-template="infoTemplate"
            ></vuetable-pagination-info>
            <vuetable-pagination ref="pagination"
                :css="css.pagination"
                @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
        </div>
        <b-modal
                ref="UserEdit"
                id="usereditmodal"
                title="Редактировать информацию о пользователе"
                ok-only
                @ok="handleOk"
                @hide="tableReload"
        >
            <user-edit :user="rowData" ref="UserEditForm" v-on:closeuserstable="ModalClose"></user-edit>
        </b-modal>
    </div>

 </template>

<script>
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import BootstrapStyle from './bootstrap-css.js'
    import UserEdit from './UserEditComponent'
    import bModal from 'bootstrap-vue/es/components/modal/modal'
    export default {
        props:['ApiUrl'],
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo,
            UserEdit,
            bModal
        },
        data(){
            return {
                rowData: '',
                css: BootstrapStyle,
                infoTemplate : "Показано с {from} по {to} из {total} записей",
                fields:[
                    {name:'second_name', title:'Фамилия'},
                    {name:'first_name', title:'Имя'},
                    {name:'patronymic_name', title:'Отчество'},
                    {
                        name:'name',
                        title:'Логин',
                        sortField: 'name'
                    },
                    {name:'email', title:'E-mail'},
                    {
                        name:'user_type.name',
                        title:'Тип',
                        titleClass: 'text-center',
                        dataClass: 'text-right'
                    },
                    {
                        name: '__slot:actions',
                        title: 'Операции',
                        titleClass: 'center aligned',
                        dataClass: 'center aligned'
                    }
                ],
                sortOrder: [
                    {
                        field: 'name',
                        sortField: 'name',
                        direction: 'asc'
                    }
                ]
            }
        },
        methods: {
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData);
                this.$refs.paginationInfo.setPaginationData(paginationData);
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
            onAction (action, data, index) {
                    this.rowData = data;
                    this.$refs.UserEditForm.clearErrors();
                    if (action == 'delete-item'){
                        axios.delete(this.ApiUrl+'/'+this.rowData.id)
                            .then(response => {
                            this.$refs.vuetable.refresh();
                        });
                    }
            },
            handleOk (evt){
                evt.preventDefault();
                this.$refs.UserEditForm.save();
            },
            tableReload () {
                this.$refs.vuetable.reload();
            },
            ModalClose () {
                this.$refs.UserEdit.hide();
            }
        }
    };
</script>

<style>
    .hero {
        background: #eee;
        padding: 1em;
    }
</style>
