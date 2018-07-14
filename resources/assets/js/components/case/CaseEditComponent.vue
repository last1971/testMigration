<template>
    <div>
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">Корпус</div>
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
        <div class="card-body">
            <div class="form-group row">
                <name-component v-model="value.name" ref="name"></name-component>
            </div>
            <div class="form-group row">
                <article-select-component v-model="value.article" ref="article"></article-select-component>
            </div>
            <image-slider-component v-model="value.pictures" ref="pictures"></image-slider-component>
            <div class="form-group row align-items-center" v-if="value.id!=0">
                <div>Алиасы</div>
                <div v-for="alias in aliases">
                    <span class="ml-1 py-2 border rounded">
                        {{alias.name.name}}
                        <div class="btn btn-md" @click="delAlias(alias)">
                            <i class="my-icons dustbin-icon"></i>
                        </div>
                    </span>
                </div>
                <div class="row">
                    <case-select-component class="ml-1" v-model="newalias" ref="newalias" onlyselect="true"></case-select-component>
                    <div class="btn btn-md" v-if="newalias && newalias.id>0" @click="addAlias">
                        <i class="my-icons add-icon"></i>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <b-button variant="primary" @click="save" class="col-md-4 offset-md-2">Сохранить</b-button>
                <b-button variant="danger" @click="cancel" class="col-md-4">Отменить</b-button>
            </div>
        </div>
    </div>
</template>

<script>
    import NameComponent from "../NameComponent";
    import ImageSliderComponent from "../ImageSliderComponent";
    import ArticleSelectComponent from "../article/ArticleSelectComponent";
    import  bButton from 'bootstrap-vue/es/components/button/button';
    import CaseSelectComponent from "../case/CaseSelectComponent";
    export default {
        components: {ArticleSelectComponent,NameComponent, ImageSliderComponent, bButton, CaseSelectComponent},
        props:['value'],
        data() {
            return {
                ApiUrl: 'cases',
                success: false,
                errors: [],
                aliases: [],
                newalias:{id:0,name_id:0,name:{id:0,name:''},pictures:[],article:{id:0,name:{id:0,name:''}}}
            }
        },
        watch:{
            value: function(){
                this.getAliases();
            }
        },
        methods:{
            save () {
                this.clearErrors();
                var newValue = this.value;
                if (newValue.article !== undefined && newValue.article != null && newValue.article.id>0) newValue.article_id = newValue.article.id;
                if (newValue.pictures != undefined && newValue.pictures.length>0) {
                    newValue.picture_id = newValue.pictures[this.$refs.pictures.ind].id;
                }
                if (newValue.name !== undefined && newValue.name.id>0) {
                    newValue.name_id = newValue.name.id;
                    axios.put(this.ApiUrl + '/' + this.value.id, newValue)
                        .then(response => {
                            this.success = true;
                            this.$emit('closecasestable');
                            if (newValue.id == 0) newValue.id = response.data.id;
                            this.$emit('input', newValue);
                        }).catch(error => {
                            this.success = false;
                            this.errors = error.response.data;
                        }
                    )
                } else {
                    this.success = false;
                    this.errors = 'Отсутсвует название корпуса';
                }
            },
            cancel () {
                this.$emit('closecasestable');
            },
            clearErrors () {
                this.errors = [];
                this.success = false;
                this.getAliases();
                this.newalias={id:0,name_id:0,name:{id:0,name:''},pictures:[],article:{id:0,name:{id:0,name:''}}};
            },
            getAliases() {
                axios.get('somecasealiases',{params:{master_id:this.value.id}})
                    .then(response => {
                        this.aliases = response.data;
                    })
                    .catch(error => {
                            this.success = false;
                            this.errors = error.response.data;
                        }
                    )
            },
            delAlias(alias) {
                axios.delete('somecasealiases/'+alias.id)
                    .then(response => {
                        this.aliases.delete(this.aliases.indexOf(alias));
                    })
                    .catch(error => {
                            this.success = false;
                            //this.errors = error.response.data;
                        }
                    )
            },
            addAlias() {
                this.newalias.master_id = this.value.id;
                axios.post('somecasealiases',this.newalias)
                    .then(response => {
                        this.aliases.push(this.newalias);
                        this.newalias={id:0,name_id:0,name:{id:0,name:''},pictures:[],article:{id:0,name:{id:0,name:''}}};
                    })
                    .catch(error => {
                            this.success = false;
                            //this.errors = error.response.data;
                        }
                    )
            }
        },
    }
</script>

<style scoped>
    .case-icon {
        display:inline-block;
        width:10px;
        height:10px;
        background-size: 100%;
    }
</style>