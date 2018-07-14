<template>
    <div class="container">
        <h1 class="justify-content-centerr">Статьи</h1>
        <vuetable ref="vuetable"
                  :api-url="ApiUrl"
                  pagination-path=""
                  @vuetable:pagination-data="onPaginationData"
                  :per-page="10"
                  :fields="fields"
                  :css="css"
                  :sort-order="sortOrder"
        >
            <template slot="actions" slot-scope="props">
                <div class="custom-actions">
                    <div class="btn btn-sm" v-b-modal.articleeditmodal
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
            <b-button size="sm" class="col-md-2" @click="addNewArticle">Создать статью</b-button>
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
                ref="ArticleEdit"
                id="articleeditmodal"
                title="Редактировать статью"
                ok-only
                @ok="handleOk"
                @hide="tableReload"
                size="lg"
        >
            <article-edit v-model="rowData" ref="ArticleEditForm" v-on:closearticlestable="ModalClose"></article-edit>
        </b-modal>
    </div>
</template>

<script>
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import BootstrapStyle from '../bootstrap-css.js'
    import ArticleEdit from './ArticleEditComponent'
    import bModal from 'bootstrap-vue/es/components/modal/modal'
    import bButton from 'bootstrap-vue/es/components/button/button';
    export default {
        props:['ApiUrl'],
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo,
            ArticleEdit,
            bModal,
            bButton
        },
        data(){
            return {
                rowData: {id:0,short_text:'',content:'',name:{id:0,name:''}},
                css: BootstrapStyle,
                infoTemplate : "Показано с {from} по {to} из {total} записей",
                fields:[
                    {name:'name.name', title:'Название'},
                    {name:'short_text', title:'Аннотация'},
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
                this.$refs.ArticleEditForm.clearErrors();
                if (action == 'delete-item'){
                    axios.delete(this.ApiUrl+'/'+this.rowData.id)
                        .then(response => {
                            this.$refs.vuetable.refresh();
                        });
                }
            },
            handleOk (evt){
                evt.preventDefault();
                this.$refs.ArticleEditForm.save();
            },
            tableReload () {
                this.$refs.vuetable.reload();
                this.$refs.ArticleEditForm.$refs.htmleditor.aga=true;
                this.$refs.ArticleEditForm.$refs.name.aga=true;
            },
            ModalClose () {
                this.$refs.ArticleEdit.hide();
            },
            addNewArticle(){
                this.rowData = {id:0,short_text:'',content:'',name:{id:0,name:''}};
                this.$refs.ArticleEditForm.clearErrors();
                this.$refs.ArticleEdit.show();
            }
        }
    }
</script>

<style scoped>

</style>