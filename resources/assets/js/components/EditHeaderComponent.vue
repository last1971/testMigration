<template>
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">{{ header }}</div>
            <div class="text-danger text-md-right col-md-6" v-if="message">
                <em>
                    {{ message }}
                </em>
            </div>
            <div class="text-success text-md-right col-md-6" v-if="success">
                <em>
                    Данные изменены
                </em>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "EditHeaderComponent",
        props:['header','message','success']
    }
</script>

<style scoped>

</style>