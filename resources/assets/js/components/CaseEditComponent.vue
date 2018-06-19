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


            <div class="form-group row">
                <b-button variant="primary" @click="save" class="col-md-4 offset-md-2">Сохранить</b-button>
                <b-button variant="danger" @click="cancel" class="col-md-4">Отменить</b-button>
            </div>
        </div>
    </div>
</template>

<script>
    import NameComponent from "./NameComponent";
    import ImageSliderComponent from "./ImageSliderComponent";
    import ArticleSelectComponent from "./ArticleSelectComponent";
    import  bButton from 'bootstrap-vue/es/components/button/button';
    export default {
        components: {ArticleSelectComponent,NameComponent, ImageSliderComponent, bButton},
        props:['value'],
        data() {
            return {
                ApiUrl: 'cases',
                success: false,
                errors: []
            }
        },
        methods:{
            save () {
                this.clearErrors();
                var newValue = this.value;
                if (newValue.article !== undefined && newValue.article.id>0) newValue.article_id = newValue.article.id;
                if (newValue.name !== undefined && newValue.name.id>0) {
                    newValue.name_id = newValue.name.id;
                    axios.put(this.ApiUrl + '/' + this.value.id, newValue)
                        .then(response => {
                            this.success = true;
                            this.$emit('closecasestable');
                            this.$emit('input', this.value);
                        }).catch(error => {
                            this.success = false;
                            this.errors = error.response.data;
                        }
                    )
                } else {
                    this.success = false;
                    this.errors = 'Отсутсвует название статьи';
                }
            },
            cancel () {
                this.$emit('closecasestable');
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