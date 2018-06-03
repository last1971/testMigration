<template>
    <div>
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">Пользователь</div>
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
            <form mathod="POST" :action="action"

            >
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Логин</label>
                    <div class="col-md-6">
                        <input required="required" autofocus="autofocus" name="name" type="text"  class="form-control" v-model="user.name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail адрес</label>
                    <div class="col-md-6">
                        <input required="required"  name="email" type="email"class="form-control" v-model="user.email" v-bind:class="{'is-invalid' : errors.errors !== undefined && errors.errors.email }">
                        <template v-if="errors.errors">
                            <span class="invalid-feedback">
                                <strong>{{errors.errors.email[0]}}</strong>
                            </span>
                        </template>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="first_name" class="col-md-4 col-form-label text-md-right">Имя</label>
                    <div class="col-md-6">
                        <input name="first_name" type="text" class="form-control" v-model="user.first_name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="patronymic_name" class="col-md-4 col-form-label text-md-right">Отчество</label>
                    <div class="col-md-6">
                        <input name="patronymic_name" type="text" class="form-control" v-model="user.patronymic_name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="second_name" class="col-md-4 col-form-label text-md-right">Фамилия</label>
                    <div class="col-md-6">
                        <input name="second_name" type="text" class="form-control" v-model="user.second_name">
                    </div>
                </div>
                <div class="form-group row" v-if="this.$store.state.user.user_type_id==1">
                    <label for="user_type_id" class="col-md-4 col-form-label text-md-right">Тип пользователя</label>
                    <div class="col-md-6">
                        <select v-model="user.user_type_id" name="user_type_id" class="form-control">
                            <option v-for="option in usertypes" v-bind:value="option.id">
                                {{ option.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <b-button variant="primary" @click="save">Сохранить</b-button>
                        <b-button variant="danger" @click="cancel">Отменить</b-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<script>
    import axios from 'axios';

    export default {

        props: ['user','action'],

        data() {
            return {
                usertypes: [],
                usertypeid: 3,
                ApiUrl: 'users',
                success: false,
                errors: []
            }
        },

        // Fetches posts when the component is created.
        created() {
            this.$store.dispatch('checkUser');
            axios.get('userTypes')
                .then(response => this.usertypes = response.data)
                .catch(e => {console.log(e);}
            )
        },
        methods:{
            save () {
                axios.put(this.ApiUrl+'/'+this.user.id,this.user)
                    .then(response => {
                        this.success = true;
                        this.$emit('closeuserstable');
                    }).catch(error => {
                        this.success = false;
                        this.errors =  error.response.data;
                    }
                )
            },
            cancel () {
                this.$emit('closeuserstable');
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