<template>
    <div class="container">
        <h1 class="justify-content-centerr">Продукты</h1>
        <filter-bar-componet v-on:filterChange="filterChange"></filter-bar-componet>
        <vuetable ref="vuetable"
                  :api-url="ApiUrl"
                  pagination-path=""
                  @vuetable:pagination-data="onPaginationData"
                  @vuetable:row-clicked="rowClicked"
                  :per-page="10"
                  :fields="fields"
                  :css="css"
                  :sort-order="sortOrder"
                  :append-params="moreParams"
        >
            <template slot="image" slot-scope="props">
                <img v-if="props.rowData.picture_id>0" :src="props.rowData.picture.path" alt="" width="100" height="100">
                <img v-else-if="props.rowData.some_case && props.rowData.some_case.picture_id>0" :src="props.rowData.some_case.picture.path" alt="" width="100" height="100">
            </template>
        </vuetable>
        <div class="vuetable-pagination row align-self-center">
            <b-button size="sm" class="col-md-2" @click="addNewProduct">Новый продукт</b-button>
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
                ref="ProductEdit"
                id="producteditmodal"
                title="Редактировать информацию о Продукте"
                ok-only
                @ok="handleOk"
                size="lg"
        >
            <product-card-component :product="rowData" ref="ProductEditForm" ></product-card-component>
        </b-modal>
    </div>

</template>

<script>
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import BootstrapStyle from '../bootstrap-css.js'
    import ProductCardComponent from './ProductCardComponent'
    import FilterBarComponet from '../FilterBarComponent'
    import bModal from 'bootstrap-vue/es/components/modal/modal'
    import bButton from 'bootstrap-vue/es/components/button/button';
    export default {
        name: "ProductTableComponent",
        props:['ApiUrl'],
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo,
            ProductCardComponent,
            bModal,
            bButton,
            FilterBarComponet,
        },
        data(){
            return {
                moreParams: {},
                rowData: {id:0,name_id:0,name:{id:0,name:''},pictures:[],article:{id:0,name:{id:0,name:''}},some_case:{id:0,name:{id:0,name:''}},producer:{id:0,name:{id:0,name:''}}},
                css: BootstrapStyle,
                infoTemplate : "Показано с {from} по {to} из {total} записей",
                fields:[
                    {
                        name: '__slot:image',
                        title: 'Рис.',
                        titleClass: 'center aligned',
                        dataClass: 'center aligned'
                    },
                    {name:'name.name', title:'Название'},
                    {name:'article.short_text', title:'Описание'},
                    {name:'producer.name.name', title:'Производитель'},
                    {name:'some_case.name.name', title:'Корпус'},

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
        methods: {
            rowClicked (dataItem,  event) {
                this.rowData = dataItem;
                this.$refs.ProductEdit.show();
            },
            filterChange (data){
                if (data.length == 0) this.moreParams = {}
                else this.moreParams.filter = data;
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
                this.$refs.ProductEditForm.clearErrors();
                if (action == 'delete-item'){
                    axios.delete(this.ApiUrl+'/'+this.rowData.id)
                        .then(response => {
                            this.$refs.vuetable.refresh();
                        });
                }
            },
            handleOk (evt){
                evt.preventDefault();
                this.$refs.ProductEdit.hide();
            },
            tableReload () {
                this.$refs.vuetable.reload();
            },
            ModalClose () {
                this.$refs.ProductEdit.hide();
            },
            addNewProduct(){
                this.rowData = {id:0,name_id:0,name:{id:0,name:''},pictures:[],article:{id:0,name:{id:0,name:''}},some_case:{id:0,name:{id:0,name:''}},producer:{id:0,name:{id:0,name:''}}};
                this.$refs.ProductEditForm.clearErrors();
                this.$refs.ProductEdit.show();
            }
        }
    }
</script>

<style scoped>

</style>