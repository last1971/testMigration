<template>
    <div>
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">Продукт</div>
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
                <producer-select-component v-model="value.producer" ref="article"></producer-select-component>
            </div>
            <div class="form-group row">
                <case-select-component v-model="value.some_case" ref="article"></case-select-component>
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
    import bButton from 'bootstrap-vue/es/components/button/button';
    import ProducerSelectComponent from "./ProducerSelectComponent";
    import CaseSelectComponent from "./CaseSelectComponent";
    export default {
        components: {
            CaseSelectComponent,
            ProducerSelectComponent, ArticleSelectComponent,NameComponent, ImageSliderComponent, bButton},
        props:['value','ApiUrl'],
        data() {
            return {
                success: false,
                errors: []
            }
        },
        methods:{
            save () {
                this.clearErrors();
                var newValue = this.value;
                if (newValue.article !== undefined && newValue.article != null && newValue.article.id>0) newValue.article_id = newValue.article.id;
                if (newValue.producer !== undefined && newValue.producer != null && newValue.producer.id>0) newValue.producer_id = newValue.producer.id;
                if (newValue.some_case !== undefined && newValue.some_case != null && newValue.some_case.id>0) newValue.some_case_id = newValue.some_case.id;
                if (newValue.pictures.length>0) {
                    newValue.picture_id = newValue.pictures[this.$refs.pictures.ind].id;
                }
                if (newValue.name !== undefined && newValue.name.id>0) {
                    newValue.name_id = newValue.name.id;
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
                    this.errors = 'Отсутсвует название продукта';
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