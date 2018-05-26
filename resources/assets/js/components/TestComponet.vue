<template>
    <div class="ui container">
        <vuetable ref="vuetable"
                  api-url="http://testmigration/users"
                  pagination-path=""
                  @vuetable:pagination-data="onPaginationData"
                  :per-page="2"
                  :fields="fields"
                  :css="css"
        ></vuetable>
        <div>
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
    import BootstrapStyle from './bootstrap-css.js'
    export default {
        components: {
            Vuetable,
            VuetablePagination
        },
        data(){
            return {
                css: BootstrapStyle,
                fields:[
                    {name:'second_name', title:'Фамилия'},
                    {name:'first_name', title:'Имя'},
                    {name:'patronymic_name', title:'Отчество'},
                    {name:'name', title:'Логин'},
                    {name:'email', title:'E-mail'},
                    {
                        name:'user_type_id',
                        title:'Тип',
                        titleClass: 'text-center',
                        dataClass: 'text-right'
                    }
                ]
            }
        },
        methods: {
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
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
