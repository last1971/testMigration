<template>
    <div class="container">
        <vuetable ref="vuetable"
                  api-url="users"
                  pagination-path=""
                  @vuetable:pagination-data="onPaginationData"
                  :per-page="2"
                  :fields="fields"
                  :css="css"
                  :sort-order="sortOrder"
        >
            <template slot="actions" slot-scope="props">
                <div class="custom-actions">
                    <button class="btn btn-sm"
                            @click="onAction('edit-item', props.rowData, props.rowIndex)">
                        <i class="oi oi-cog"></i>
                    </button>
                    <button class="btn btn-sm"
                            @click="onAction('delete-item', props.rowData, props.rowIndex)">
                        <i class="oi oi-circle-x"></i>
                    </button>
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
    </div>
 </template>

<script>
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import BootstrapStyle from './bootstrap-css.js'
    export default {
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo
        },
        data(){
            return {
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
                        name:'user_type_id',
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
                console.log('slot) action: ' + action, data.id, index);
                if (action == 'edit-item'){
                    $.get('users/' + data.id + '/edit',{},function(data){
                        var user_edit = $('.user-edit');
                        user_edit.find('.modal-body').html(data);
                        user_edit.modal('show');
                    },'html');
                }
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
