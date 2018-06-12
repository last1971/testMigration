<template>
    <div>
    <div>
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">Статья</div>
                <div class="text-danger text-md-right col-md-6" v-if="errors.message">
                    <em>
                        {{ errors.message }}
                    </em>
                </div>
                <div class="text-success text-md-right col-md-6" v-if="success">
                    <em>
                        Данные изменены
                    </em>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <name-component v-model="value.name" ref="name"></name-component>
        </div>
        <div class="form-group row">
            <input type="text"  class="form-control" v-model="value.short_text" placeholder="Аннотация"/>
        </div>
        <div class="form-group row">
            <html-editor-component v-model="value.content" ref="htmleditor"></html-editor-component>
        </div>
        <div class="form-group row">

                <b-button variant="primary" @click="save" class="col-md-4 offset-md-2">Сохранить</b-button>
                <b-button variant="danger" @click="cancel" class="col-md-4">Отменить</b-button>

        </div>
    </div>
    </div>
</template>

<script>
    import NameComponent from "./NameComponent";
    import HtmlEditorComponent from "./HtmlEditorComponent";
    import  bButton from 'bootstrap-vue/es/components/button/button';
    export default {
        name: "ArticleEditComponent",
        components: {HtmlEditorComponent, NameComponent, bButton},
        props: ['value','action'],

        data() {
            return {
                //article: this.value,//{id:0,short_text:'',content:'',name:{id:0,name:''}},
                ApiUrl: 'articles',
                success: false,
                errors: []
            }
        },
        methods:{
            save () {
                this.clearErrors();
                axios.put(this.ApiUrl+'/'+this.value.id,this.value)
                    .then(response => {
                        this.success = true;
                        this.$emit('closearticlestable');
                        this.$emit('input',this.value);
                    }).catch(error => {
                        this.success = false;
                        this.errors =  error.response.data;
                    }
                )
            },
            cancel () {
                this.$emit('closearticlestable');
            },
            clearErrors () {
                this.errors = [];
                this.success = false;
            },
        },

    }
</script>

<style scoped>

</style>