<template>
    <div>
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">Категория</div>
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
            <div class="form-group row">
                <image-select-component v-model="value.picture" ref="picture"></image-select-component>
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
    import ImageSelectComponent from "../ImageSelectComponent";
    export default {
        components: {ImageSelectComponent, ArticleSelectComponent,NameComponent, ImageSliderComponent, bButton},
        props:['value','expanded'],
        data() {
            return {
                ApiUrl: 'categories',
                success: false,
                errors: []
            }
        },
        methods:{
            save () {
                this.clearErrors();
                var newValue = this.value;
                if (newValue.article !== undefined && newValue.article != null && newValue.article.id>0) newValue.article_id = newValue.article.id;
                if (newValue.picture != undefined && newValue.picture != null && newValue.picture.id>0 ) {
                    newValue.picture_id = newValue.picture.id;
                }
                if (newValue.name !== undefined && newValue.name.id>0) {
                    newValue.name_id = newValue.name.id;
                    newValue.expanded = this.expanded;
                    axios.put(this.ApiUrl + '/' + this.value.id, newValue)
                        .then(response => {
                            this.success = true;
                            this.$emit('close');
                            if (newValue.id == 0) newValue.id = response.data.id;
                            this.$emit('input', newValue);
                        }).catch(error => {
                            this.success = false;
                            this.errors = error.response.data;
                        }
                    )
                } else {
                    this.success = false;
                    this.errors = 'Отсутсвует название категории';
                }
            },
            cancel () {
                this.$emit('close');
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