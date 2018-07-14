<template>
    <div>
        <edit-header-component header="Фирма" :message="errors.message" :success="success"></edit-header-component>
        <div class="card-body">
            <div class="form-group row">
                <name-component v-model="value.name" ref="name"></name-component>
            </div>
            <div class="form-group row">
                <input v-model="value.full_name" ref="full_name" required />
            </div>
            <div class="form-group row">
                <input v-model="value.inn" ref="inn" required />
            </div>
            <div class="form-group row">
                <input v-model="value.kpp" ref="kpp" required />
            </div>
            <div class="form-group row">
                <input v-model="value.own" type="checkbox" id="own_id" ref="own" required />
                <label for="own_id">Своя</label>
            </div>
            <div class="form-group row">
                <b-button variant="primary" @click="save" class="col-md-4 offset-md-2">Сохранить</b-button>
                <b-button variant="danger" @click="cancel" class="col-md-4">Отменить</b-button>
            </div>
            <div class="form-group row" v-if="value.id!=0">
                <store-table-component :firm="value" ApiUrl="stores" ref="stores"></store-table-component>
            </div>
        </div>
    </div>
</template>

<script>
    import NameComponent from "../NameComponent";
    import  bButton from 'bootstrap-vue/es/components/button/button';
    import EditHeaderComponent from "../EditHeaderComponent";
    import StoreTableComponent from "../store/StoreTableComponent";
    export default {
        components: {
            StoreTableComponent,
            EditHeaderComponent, NameComponent, bButton},
        props:['value'],
        data() {
            return {
                ApiUrl: 'firms',
                success: false,
                errors: []
            }
        },
        methods:{
            save () {
                this.clearErrors();
                var newValue = this.value;
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
                    this.errors = 'Отсутсвует название фирмы';
                }
            },
            cancel () {
                this.$emit('close');
            },
            clearErrors () {
                this.errors = [];
                this.success = false;
            }
        },
    }
</script>

<style scoped>

</style>